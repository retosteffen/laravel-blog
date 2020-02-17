<?php

namespace Retosteffen\LaravelBlog\Http\Controllers;

use Illuminate\Http\Request;


use Retosteffen\LaravelBlog\Models\Category;
use Retosteffen\LaravelBlog\Models\LaravelBlog;
class CategoryController
{

  public function index(Request $request)
  {

    $categories=Category::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);

    return view('laravel-blog::category.index',compact('categories'));
  }


  public function create(Request $request)
  {

    return view('laravel-blog::category.create');
  }

  public function store(Request $request)
  {

    $attributes=request()->validate([
      'name'=>['required'],
      ]);

      $category = Category::create($attributes);

      return redirect()->route('categories');
  }


  public function show(Category $category)
  {

    $item=$category;
    $posts=LaravelBlog::where('published','=',true)->where('category_id','=',$item->id)->orderBy('published_at','desc')->get();
      return view('laravel-blog::archive',compact('item','posts'));
  }



  public function edit(Category $category)
  {
    return view('laravel-blog::category.edit',compact('category'));
  }


  public function update(Request $request,Category $category)
  {
    $attributes=request()->validate([
    'name'=>['required'],
    ]);


    $category->update($attributes);
    return redirect()->route('categories');
  }






  public function destroy(Category $category)
  {
    $category->delete();
    return redirect()->route('categories');
  }


}
