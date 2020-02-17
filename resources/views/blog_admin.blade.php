@extends('laravel-blog::layout')

@section('title')
  {{__('laravel-blog::laravel-blog.blog_admin')}}
@endsection



@section('content')
  <h1>{{__('laravel-blog::laravel-blog.administer_blog')}}</h1>
  <hr>
  <p><a href='{{ config('laravel-blog.adminroute') }}/categories'>{{__('laravel-blog::laravel-blog.categories')}}</a></p>
  <p><a href='{{ config('laravel-blog.adminroute') }}/tags'>{{__('laravel-blog::laravel-blog.tags')}}</a></p>
  <p><a href='{{ config('laravel-blog.route') }}/create'>{{__('laravel-blog::laravel-blog.create_post')}}</a></p>
  <table style='width:100%; border:1px solid black; text-align:left;'>
    <thead>
      <tr>
        <th>{{__('laravel-blog::laravel-blog.title')}}</th><th>{{__('laravel-blog::laravel-blog.author')}}</th><th>{{__('laravel-blog::laravel-blog.category')}}</th><th>{{__('laravel-blog::laravel-blog.tags')}}</th><th>{{__('laravel-blog::laravel-blog.date')}}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($posts as $post)
        <tr>
          <td><a href='{{ config('laravel-blog.route') }}/{{$post->slug}}/edit'>{{$post->title}}</a></td>
          <td>{{$post->author->name}}</td>
          <td>@if($post->category){{$post->category->name}}@endif</td>
            <td>@foreach ($post->tags as $tag)
              <span>{{$tag->name}}@if (!$loop->last), @endif</span>
              @endforeach</td>
              <td>@if (!$post->published) {{__('laravel-blog::laravel-blog.draft')}}@else{{$post->published_at}}@endif</td>
              </tr>
            @endforeach

          </tbody>
          <tfoot>
          </tfoot>
        </table>
      @endsection
