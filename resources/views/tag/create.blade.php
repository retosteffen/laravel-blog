@extends('laravel-blog::layout')

@section('title')
  {{__('laravel-blog::laravel-blog.create_tag')}} - {{ config('laravel-blog.blog_name') }}
@endsection

@section('content')
  <h1>{{__('laravel-blog::laravel-blog.create_tag')}}</h1>

  <form method="POST" action="{{ config('laravel-blog.adminroute') }}/tags/">
    @csrf
    <div>
      <label for="name">{{__('laravel-blog::laravel-blog.name')}}</label>
      <input type="text" name="name" value="{{old('name')}}">
    </div>
    <div>
      <button type="submit">{{__('laravel-blog::laravel-blog.save_tag')}}</button>
    </div>
    <div>
      <a href="{{url()->previous()}}">{{__('laravel-blog::laravel-blog.cancel')}}</a>
    </div>
    @include('laravel-blog::errors')
  </form>
@endsection
