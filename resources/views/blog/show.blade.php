@extends('laravel-blog::layout')
@section('title')
  {{$blogPost->title}} - {{ config('laravel-blog.blog_name') }}
@endsection
@section('meta')
  @if ($blogPost->excerpt)
  <meta name="description" content="{{$blogPost->excerpt}}">
@else
  <meta name="description" content="{{str_limit($blogPost->content,$limit = 158,$end="")}}">
@endif
  <meta name="keywords" content="blog, {{$blogPost->tags->pluck('name')->implode(', ')}}">
  <meta name="author" content="{{$blogPost->author->name}}">
  <link rel="canonical" href=@include('laravel-blog::post_link',['item'=>$blogPost])>
  <meta property="og:locale" content="{{config('laravel-blog.locale')}}">
  <meta property="og:type" content="article">
  <meta property="og:title" content="{{$blogPost->title}}">
  <meta property="og:description" content="{{$blogPost->excerpt}}">
  <meta property="og:url" content=@include('laravel-blog::post_link',['item'=>$blogPost])>
  <meta property="og:site_name" content="{{config('laravel-blog.site_name')}}">
  <meta property="article:publisher" content="{{config('laravel-blog.facebook_name')}}">
  <meta property="article:author" content="{{config('laravel-blog.facebook_name')}}">
  @foreach ($blogPost->tags as $tag)
    <meta property="article:tag" content="{{$tag->name}}">
  @endforeach
  @if($blogPost->category)
    <meta property="article:section" content="{{$blogPost->category->name}}">
  @endif
  <meta property="article:published_time" content="{{$blogPost->published_at}}">
  <meta property="article:modified_time" content="{{$blogPost->updated_time}}">
  <meta property="og:updated_time" content="{{$blogPost->updated_time}}">
  <meta property="og:image" content="">
  <meta property="og:image:secure_url" content="">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:description" content="{{$blogPost->excerpt}}">
  <meta name="twitter:title" content="{{$blogPost->title}}">
  <meta name="twitter:site" content="{{config('laravel-blog.twitter_handle')}}">
  <meta name="twitter:image" content="">
  <meta name="twitter:creator" content="{{config('laravel-blog.twitter_handle')}}">


@endsection


@section('content')

  <img src="{{$blogPost->image}}" width='100%' style="max-height:200px; object-fit:cover">
  <div class='row justify-content-left'><div class='col-lg-8 col-md-12'>
    <h1>{{$blogPost->title}}</h1>
    @if (auth()->user())
      @if (auth()->user() == $blogPost->author || auth()->user()->role === 'admin')
        <a class='btn btn-primary btn-sm float-right' href="{{ config('laravel-blog.route') }}/{{$blogPost->slug}}/edit"><i class="fas fa-edit"></i> {{__('laravel-blog::laravel-blog.edit')}}</a>
      @endif
    @endif

    <p class="text-right">{{$blogPost->published_at}} {{__('laravel-blog::laravel-blog.by')}} {{$blogPost->author->name}}</p>
    <hr>
    {{ $blogPost->content }}
    <hr>
    <div class="clearfix">
      @if ($blogPost->category)
        <div>{{__('laravel-blog::laravel-blog.category')}}:
          <span><a href='{{ config('laravel-blog.route') }}/category/{{$blogPost->category->slug}}'>{{$blogPost->category->name}}</a></span>
        </div>
      @endif
      @if ($blogPost->tags)
        {{__('laravel-blog::laravel-blog.tags')}}:
        @foreach ($blogPost->tags as $tag)
          <span><a href="{{ config('laravel-blog.route') }}/tag/{{$tag->slug}}">{{$tag->name}}</a></span>
        @endforeach
      @endif
      <hr>



      @if ($blogPost->published && $blogPost->previousItem())
        <span><i class="fas fa-caret-square-left"></i> {{__('laravel-blog::laravel-blog.previous')}}: <a href=@include('laravel-blog::post_link',['item'=>$blogPost->previousItem()])>{{$blogPost->previousItem()->title}}</a></span>
      @endif


      @if ($blogPost->published && $blogPost->nextItem())
        <span class='float-right'><a href=@include('laravel-blog::post_link',['item'=>$blogPost->nextItem()])>{{$blogPost->nextItem()->title}}</a>: {{__('laravel-blog::laravel-blog.next')}} <i class="fas fa-caret-square-right"></i></span>
      @endif

    </div>



  </div>



@endsection
