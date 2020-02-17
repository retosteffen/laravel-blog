@extends('laravel-blog::layout')

@section('title')
  {{__('laravel-blog::laravel-blog.your_categories')}} - {{ config('laravel-blog.blog_name') }}
@endsection

@section('content')
  <h1>{{__('laravel-blog::laravel-blog.your_categories')}}</h1>
  <a href='{{ config('laravel-blog.adminroute') }}'>{{__('laravel-blog::laravel-blog.back_to_admin')}}</a>
  <ul>
    @foreach ($categories as $category)
      <li>{{$category->name}} <form method="POST" action="{{ config('laravel-blog.adminroute') }}/categories/{{$category->slug}}/">
        @method('DELETE')
        @csrf
        <div>
          <button type="submit" onclick="return confirm('{{__('laravel-blog::laravel-blog.are_you_sure')}}');"><i class="fas fa-trash"></i> {{__('laravel-blog::laravel-blog.delete_category')}}</button></div>
        </form>
        <a href='{{ config('laravel-blog.adminroute') }}/categories/{{$category->slug}}/edit'>{{__('laravel-blog::laravel-blog.edit_category')}}</a>
      </li>
    @endforeach
  </ul>

  <a href="{{ config('laravel-blog.adminroute') }}/categories/create"> {{__('laravel-blog::laravel-blog.create_category')}}</a>
@endsection
