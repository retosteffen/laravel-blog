@foreach ($posts as $post)
  <article class="post">
    <h2>{{$post->title}}</h2>
    <p>{{$post->published_at}} {{ __('laravel-blog::laravel-blog.by') }} <a href="{{ config('laravel-blog.route') }}/author/{{$post->author->name}}">{{$post->author->name}}</a></p>
    <div>{{ str_limit($post->content,$limit = 150, $end = '...') }}</div>
    @if($post->category)
      <div>{{ __('laravel-blog::laravel-blog.category') }}:
        <span><a href='{{ config('laravel-blog.route') }}/category/{{$post->category->slug}}'>{{$post->category->name}}</a></span>
      </div>
    @endif
    <div>{{ __('laravel-blog::laravel-blog.tags') }}:
      @foreach ($post->tags as $tag)
        <span><a href="{{ config('laravel-blog.route') }}/tag/{{$tag->slug}}">{{$tag->name}}</a></span>
      @endforeach</div>


      <a href=@include('laravel-blog::post_link',['item'=>$post])>{{ __('laravel-blog::laravel-blog.read_more') }}</a>


    </article>
  @endforeach
