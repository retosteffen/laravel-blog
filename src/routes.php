<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get(config('laravel-blog.route').'/create', 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@create');

        Route::post(config('laravel-blog.route'), 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@store');
        Route::get(config('laravel-blog.route').'/{blogPost}/edit', 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@edit');
        Route::patch(config('laravel-blog.route').'/{blogPost}', 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@update');
        Route::delete(config('laravel-blog.route').'/{blogPost}', 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@destroy');

        Route::get(config('laravel-blog.adminroute'), 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@admin_page')->name('blog_admin');

        Route::get(config('laravel-blog.adminroute').'/tags', 'Retosteffen\LaravelBlog\Http\Controllers\TagController@index')->name('tags');
        Route::get(config('laravel-blog.adminroute').'/tags/create', 'Retosteffen\LaravelBlog\Http\Controllers\TagController@create');
        Route::post(config('laravel-blog.adminroute').'/tags', 'Retosteffen\LaravelBlog\Http\Controllers\TagController@store');
        Route::get(config('laravel-blog.adminroute').'/tags/{tag}/edit', 'Retosteffen\LaravelBlog\Http\Controllers\TagController@edit');
        Route::patch(config('laravel-blog.adminroute').'/tags/{tag}', 'Retosteffen\LaravelBlog\Http\Controllers\TagController@update');
        Route::delete(config('laravel-blog.adminroute').'/tags/{tag}', 'Retosteffen\LaravelBlog\Http\Controllers\TagController@destroy');

        Route::get(config('laravel-blog.adminroute').'/categories', 'Retosteffen\LaravelBlog\Http\Controllers\CategoryController@index')->name('categories');
        Route::get(config('laravel-blog.adminroute').'/categories/create', 'Retosteffen\LaravelBlog\Http\Controllers\CategoryController@create');
        Route::post(config('laravel-blog.adminroute').'/categories', 'Retosteffen\LaravelBlog\Http\Controllers\CategoryController@store');
        Route::get(config('laravel-blog.adminroute').'/categories/{category}/edit', 'Retosteffen\LaravelBlog\Http\Controllers\CategoryController@edit');
        Route::patch(config('laravel-blog.adminroute').'/categories/{category}', 'Retosteffen\LaravelBlog\Http\Controllers\CategoryController@update');
        Route::delete(config('laravel-blog.adminroute').'/categories/{category}', 'Retosteffen\LaravelBlog\Http\Controllers\CategoryController@destroy');
    });

    Route::get(config('laravel-blog.route'), 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@index');

    //show blog post
    //different permalink methods

    //id
    Route::get(config('laravel-blog.route').'/{id}', 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@showID')->where('id', '[0-9]+')->name('showID');
    //year/month/slug
    Route::get(config('laravel-blog.route').'/{year}/{month}/{blogPost}', 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@showYearMonthSlug')->name('showYearMonthSlug');
    //year/month/day/slug
    Route::get(config('laravel-blog.route').'/{year}/{month}/{day}/{blogPost}', 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@showYearMonthDaySlug')->name('showYearMonthDaySlug');
    //slug
    Route::get(config('laravel-blog.route').'/{blogPost}', 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@showSlug')->where('blogPost', '[a-z0-9\-]+')->name('showSlug');

    Route::get(config('laravel-blog.route').'/category/{category}', 'Retosteffen\LaravelBlog\Http\Controllers\CategoryController@show');

    Route::get(config('laravel-blog.route').'/tag/{slug}', 'Retosteffen\LaravelBlog\Http\Controllers\TagController@show');

    Route::get(config('laravel-blog.route').'/author/{name}', 'Retosteffen\LaravelBlog\Http\Controllers\LaravelBlogController@indexAuthor');
});
