<?php

namespace Retosteffen\LaravelBlog\Http\Controllers;

use Illuminate\Http\Request;
use Retosteffen\LaravelBlog\Models\LaravelBlog;
use Spatie\Tags\Tag;

class TagController
{
    public function index(Request $request)
    {
        $tags = Tag::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        return view('laravel-blog::tag.index', compact('tags'));
    }

    public function create(Request $request)
    {
        return view('laravel-blog::tag.create');
    }

    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name'=>['required'],
        ]);

        $tag = Tag::findOrCreate($attributes['name']);

        return redirect()->route('tags');
    }

    public function show($slug)
    {
        $tag = Tag::findFromSlug($slug);

        $item = $tag;

        $posts = LaravelBlog::where('published', '=', true)->withAnyTags([$tag])->get();

        return view('laravel-blog::archive', compact('item', 'posts'));
    }

    public function edit(Tag $tag)
    {
        return view('laravel-blog::tag.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $attributes = request()->validate([
            'name'=>['required'],
        ]);

        $tag->update($attributes);

        return redirect()->route('tags');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tags');
    }
}
