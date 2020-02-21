@extends('laravel-blog::layout')

@section('title')
  {{__('laravel-blog::laravel-blog.edit_post')}} - {{ config('laravel-blog.blog_name') }}
@endsection

@section('content')
  <h1>{{__('laravel-blog::laravel-blog.edit_post')}} "{{$blogPost->title}}"</h1>
  <div class="container">
    <form method="POST" action="{{ config('laravel-blog.route') }}/{{$blogPost->slug}}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <div>
        <label for="title">{{__('laravel-blog::laravel-blog.title')}}</label>
        <input type="text" name="title" value="{{$blogPost->title}}">
      </div>
      <div>
        <label for="content">{{__('laravel-blog::laravel-blog.content')}}</label>
        <textarea name="content" rows="10" cols="100">{{$blogPost->content}}</textarea>
      </div>
      <div>
        <label for="excerpt">{{__('laravel-blog::laravel-blog.excerpt')}}</label>
        <textarea name="excerpt" rows="4" cols="100">{{$blogPost->excerpt}}</textarea>
        <div><small id="excerpt_idHelp">{{__('laravel-blog::laravel-blog.excerpt_help')}}</small></div>
      </div>

      <div>
        <label for="category">{{__('laravel-blog::laravel-blog.category')}}</label>
        <select id="category" name="category">
          <option value="">----</option>
          @foreach ($categories as $category)
            <option value="{{$category->id}}" @if ($blogPost->category && $blogPost->category->id == $category->id) selected @endif>{{$category->name}}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label for="image">{{__('laravel-blog::laravel-blog.image')}}</label>
          <input type="file" name="image" id='image'/>
        </div>
        @if ($blogPost->image)
        <div>
          <span>{{__('laravel-blog::laravel-blog.current_image')}}</span>
          <img src="{{ asset('storage/'.$blogPost->image) }}" width='100px'>
        </div>
      @endif
      <div>
        <label for="alt_text">{{__('laravel-blog::laravel-blog.alt_text')}}</label>
        <input type="text" name="alt_text" value="{{$blogPost->alt_text}}">
      </div>

        <div>
          <label for="tags_id">{{__('laravel-blog::laravel-blog.tags')}}</label>
          <select multiple id="tags_id" name="tags[]">
            @foreach ($tags as $tag)
              <option value="{{$tag->id}}" @if ($blogPost->tags->contains($tag)) selected @endif>{{$tag->name}}</option>
              @endforeach
            </select>
            <div><small id="tags_idHelp">{{__('laravel-blog::laravel-blog.multi_select')}}</small></div>
          </div>
          <div>
            <input type="checkbox" id="published" name="published" @if ($blogPost->published) checked @endif>
              <label for="published">{{__('laravel-blog::laravel-blog.published')}}</label>
            </div>
            <div>
              <button type="submit">{{__('laravel-blog::laravel-blog.edit_post')}}</button>
            </div>
            <div>
              <a href="{{url()->previous()}}">{{__('laravel-blog::laravel-blog.cancel')}}</a>
            </div>

            @include('laravel-blog::errors')
          </form>
          <form method="POST" action="{{ config('laravel-blog.route') }}/{{$blogPost->slug}}" style="padding-top:2em;">
            @method('DELETE')
            @csrf
            <div>
              <button type="submit" onclick="return confirm('{{__('laravel-blog::laravel-blog.are_you_sure')}}');">{{__('laravel-blog::laravel-blog.delete_post')}}</button>
            </div>
          </form>

        </div>
      @endsection

      @section('javascript')
      @endsection
