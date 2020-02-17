@extends('laravel-blog::layout')

@section('title')
  {{__('laravel-blog::laravel-blog.your_tags')}} - {{ config('laravel-blog.blog_name') }}
@endsection

@section('content')
  <h1>{{__('laravel-blog::laravel-blog.your_tags')}}</h1>
  <a href='{{ config('laravel-blog.adminroute') }}'>{{__('laravel-blog::laravel-blog.back_to_admin')}}</a>
  <ul>
    @foreach ($tags as $tag)
      <li>{{$tag->name}} <form method="POST" action="{{ config('laravel-blog.adminroute') }}/tags/{{$tag->id}}/">
        @method('DELETE')
        @csrf
        <div>
          <button type="submit" onclick="return confirm('{{__('laravel-blog::laravel-blog.are_you_sure')}}');"><i class="fas fa-trash"></i> {{__('laravel-blog::laravel-blog.delete_tag')}}</button>
        </div>
      </form>
      <a href='{{ config('laravel-blog.adminroute') }}/tags/{{$tag->id}}/edit'>{{__('laravel-blog::laravel-blog.edit_tag')}}</a>
    </li>
  @endforeach
</ul>

<a href="{{ config('laravel-blog.adminroute') }}/tags/create"> {{__('laravel-blog::laravel-blog.create_tag')}}</a>
@endsection
