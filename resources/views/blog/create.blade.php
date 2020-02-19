@extends('laravel-blog::layout')

@section('title')
  {{__('laravel-blog::laravel-blog.create_post')}} - {{ config('laravel-blog.blog_name') }}
@endsection

@section('content')
  <h1>{{__('laravel-blog::laravel-blog.create_post')}}</h1>
  <div class="container">
XXXXXX
    <form method="POST" action="{{ config('laravel-blog.route') }}">
      @csrf
      <div>
        <label for="title">{{__('laravel-blog::laravel-blog.title')}}</label>
        <input type="text" name="title" value="{{old('title')}}">
      </div>
      <div>
        <label for="content">{{__('laravel-blog::laravel-blog.content')}}</label>
        <textarea name="content" rows="10" cols="100">{{old('content')}}</textarea>
      </div>

      <div>
        <label for="excerpt">{{__('laravel-blog::laravel-blog.excerpt')}}</label>
        <textarea name="excerpt" rows="4" cols="100">{{old('excerpt')}}</textarea>
        <div><small id="excerpt_idHelp">{{__('laravel-blog::laravel-blog.excerpt_help')}}</small></div>
      </div>

      <div>
        <label for="category">{{__('laravel-blog::laravel-blog.category')}}</label>
        <select id="category" name="category">
          <option value="">----</option>
          @foreach ($categories as $category)
            <option value="{{$category->id}}" @if (old('category') && $category->id == old('category')) selected @endif>{{$category->name}}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label for="image">{{__('laravel-blog::laravel-blog.image')}}</label>
          <input type="file" name="image" id='image'/>
        </div>
        <div>
          <label for="tags_id">{{__('laravel-blog::laravel-blog.tags')}}</label>
          <select multiple id="tags_id" name="tags[]">
            @foreach ($tags as $tag)
              <option value="{{$tag->id}}" @if (old('tags') && in_array($tag->id,old('tags'))) selected @endif>{{$tag->name}}</option>
              @endforeach
            </select><div>
              <small id="tags_idHelp">{{__('laravel-blog::laravel-blog.multi_select')}}</small></div>
            </div>
            <div>
              <input type="checkbox" id="published" name="published">

              <label for="published">{{__('laravel-blog::laravel-blog.published')}}</label>
            </div>
            <div>
              <button type="submit">{{__('laravel-blog::laravel-blog.save_post')}}</button>
            </div>
            <div>
              <a href="{{url()->previous()}}">{{__('laravel-blog::laravel-blog.cancel')}}</a>
            </div>

            @include('laravel-blog::errors')
          </form>


        </div>
      @endsection

      @section('javascript')

      @endsection
