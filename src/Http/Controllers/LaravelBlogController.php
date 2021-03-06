<?php

namespace Retosteffen\LaravelBlog\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Retosteffen\LaravelBlog\Models\Category;
use Retosteffen\LaravelBlog\Models\LaravelBlog;
use Spatie\Tags\Tag;

class LaravelBlogController
{
    public function index()
    {
        $posts = LaravelBlog::where('published', '=', true)->orderBy('published_at', 'desc')->get();

        return view('laravel-blog::blog.index', compact('posts'));
    }

    public function create(Request $request)
    {
        //$this->authorize('create',[LaravelBlog::class]);

        $tags = Tag::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);
        $categories = Category::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        return view('laravel-blog::blog.create', compact('tags', 'categories'));
    }

    public function store(Request $request)
    {
        //$this->authorize('create',[LaravelBlog::class]);
        $attributes = request()->validate([
            'title'=>['required', 'regex:/^(?![0-9]*$)[a-zA-Z0-9 \-]+$/'],
            'content'=>['required'],
            'excerpt'=>['max:158'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'alt_text'=>[],
        ]);
        $attributes['published'] = request()->has('published');

        if (request()->has('published')) {
            $attributes['published_at'] = date('Y-m-d H:i:s');
        }

        $blog_post = LaravelBlog::create($attributes);
        $blog_post->author()->associate(auth()->user());
        $blog_post->category()->associate(request()->get('category'));
        $blog_post->save();

        $image_path = null;
        if ($request->file('image')) {
            $original_file_name = $request->file('image')->getClientOriginalName();
            $image_path = $request->file('image')->storeAs('blog_posts/'.$blog_post->id, $original_file_name, 'public');
        }
        $blog_post->image = $image_path;
        $blog_post->save();

        $tags_array = $request->get('tags');
        $tags_names_array = [];
        if ($tags_array) {
            foreach ($tags_array as $tag_id) {
                $tag_object = Tag::find($tag_id);
                $tags_names_array[] = $tag_object->name;
            }
            $blog_post->syncTagsWithType($tags_names_array);
        } else {
            $blog_post->syncTags([]);
        }

        return redirect()->route('blog_admin');
    }

    public function showSlug(LaravelBlog $blogPost)
    {
        if (! $blogPost->published && ! auth()->user()) {
            abort(404);
        }

        if (config('laravel-blog.permalink') == 'year/month/slug') {
            return redirect()->route('showYearMonthSlug', ['year'=>\Carbon\Carbon::parse($blogPost->published_at)->year, 'month'=>\Carbon\Carbon::parse($blogPost->published_at)->month, 'blogPost' => $blogPost->slug]
      );
        }
        if (config('laravel-blog.permalink') == 'year/month/day/slug') {
            return redirect()->route('showYearMonthDaySlug', ['year'=>\Carbon\Carbon::parse($blogPost->published_at)->year, 'month'=>\Carbon\Carbon::parse($blogPost->published_at)->month, 'day'=>\Carbon\Carbon::parse($blogPost->published_at)->day, 'blogPost' => $blogPost->slug]
      );
        }
        if (config('laravel-blog.permalink') == 'id') {
            return redirect()->route('showID', ['id' => $blogPost->id]
      );
        }

        return view('laravel-blog::blog.show', compact('blogPost'));
    }

    public function showYearMonthSlug($year, $month, LaravelBlog $blogPost)
    {
        if (! $blogPost->published && ! auth()->user()) {
            abort(404);
        }

        if (config('laravel-blog.permalink') == 'slug') {
            return redirect()->route('showSlug', ['blogPost' => $blogPost->slug]
      );
        }
        if (config('laravel-blog.permalink') == 'id') {
            return redirect()->route('showID', ['id' => $blogPost->id]
      );
        }
        if (config('laravel-blog.permalink') == 'year/month/day/slug') {
            return redirect()->route('showYearMonthDaySlug', ['year'=>$year, 'month'=>$month, 'day'=>\Carbon\Carbon::parse($blogPost->published_at)->day, 'blogPost' => $blogPost->slug]
      );
        }

        return view('laravel-blog::blog.show', compact('blogPost'));
    }

    public function showYearMonthDaySlug($year, $month, $day, LaravelBlog $blogPost)
    {
        if (! $blogPost->published && ! auth()->user()) {
            abort(404);
        }
        if (config('laravel-blog.permalink') == 'slug') {
            return redirect()->route('showSlug', ['blogPost' => $blogPost->slug]
      );
        }
        if (config('laravel-blog.permalink') == 'id') {
            return redirect()->route('showID', ['id' => $blogPost->id]
      );
        }
        if (config('laravel-blog.permalink') == 'year/month/slug') {
            return redirect()->route('showYearMonthSlug', ['year'=>$year, 'month'=>$month, 'blogPost' => $blogPost->slug]
      );
        }

        return view('laravel-blog::blog.show', compact('blogPost'));
    }

    public function showID($id)
    {
        $blogPost = LaravelBlog::find($id);
        if ($blogPost && ! $blogPost->published && ! auth()->user()) {
            abort(404);
        }

        if (config('laravel-blog.permalink') == 'slug') {
            return redirect()->route('showSlug', ['blogPost' => $blogPost->slug]
      );
        }
        if (config('laravel-blog.permalink') == 'year/month/slug') {
            return redirect()->route('showYearMonthSlug', ['year'=>\Carbon\Carbon::parse($blogPost->published_at)->year, 'month'=>\Carbon\Carbon::parse($blogPost->published_at)->month, 'blogPost' => $blogPost->slug]
      );
        }
        if (config('laravel-blog.permalink') == 'year/month/day/slug') {
            return redirect()->route('showYearMonthDaySlug', ['year'=>\Carbon\Carbon::parse($blogPost->published_at)->year, 'month'=>\Carbon\Carbon::parse($blogPost->published_at)->month, 'day'=>\Carbon\Carbon::parse($blogPost->published_at)->day, 'blogPost' => $blogPost->slug]
      );
        }

        return view('laravel-blog::blog.show', compact('blogPost'));
    }

    public function edit(LaravelBlog $blogPost)
    {
        //$this->authorize('update',$blogPost);

        $tags = Tag::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);
        $categories = Category::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        return view('laravel-blog::blog.edit', compact('blogPost', 'tags', 'categories'));
    }

    public function update(Request $request, LaravelBlog $blogPost)
    {
        //$this->authorize('update',$blogPost);
        $attributes = request()->validate([
            'title'=>['required', 'regex:/^(?![0-9]*$)[a-zA-Z0-9 \-]+$/'],
            'content'=>['required'],
            'excerpt'=>['max:158'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'alt_text'=>[],
        ]);
        $attributes['published'] = request()->has('published');

        if ($request->file('image')) {
            $original_file_name = $request->file('image')->getClientOriginalName();
            $image_path = $request->file('image')->storeAs('blog_posts/'.$blogPost->id, $original_file_name, 'public');
        } else {
            $image_path = $blogPost->image;
        }

        if ($blogPost->published == false && request()->has('published')) {
            $attributes['published_at'] = date('Y-m-d H:i:s');
        }

        $blogPost->category()->associate(request()->get('category'));

        $tags_array = $request->get('tags');
        $tags_names_array = [];
        if ($tags_array) {
            foreach ($tags_array as $tag_id) {
                $tag_object = Tag::find($tag_id);
                $tags_names_array[] = $tag_object->name;
            }
            $blogPost->syncTagsWithType($tags_names_array);
        } else {
            $blogPost->syncTags([]);
        }

        $blogPost->update($attributes);

        $blogPost->image = $image_path;
        $blogPost->save();

        return redirect()->route('blog_admin');
    }

    public function destroy(LaravelBlog $blogPost)
    {
        //$this->authorize('destroy',$blogPost);
        $blogPost->delete();

        return redirect()->route('blog_admin');
    }

    public function admin_page()
    {
        $posts = LaravelBlog::orderBy('published_at', 'desc')->get();

        return view('laravel-blog::blog_admin', compact('posts'));
    }

    public function indexAuthor($user_name)
    {
        $item = User::where('name', '=', $user_name)->first();
        $posts = LaravelBlog::where('published', '=', true)->where('user_id', '=', $item->id)->orderBy('published_at', 'desc')->get();

        return view('laravel-blog::archive', compact('item', 'posts'));
    }
}
