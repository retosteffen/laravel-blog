@if (config('laravel-blog.permalink') == "slug")
  {{ config('laravel-blog.route') }}/{{$item->slug}}
@elseif (config('laravel-blog.permalink') == "year/month/slug")
  {{ config('laravel-blog.route') }}/{{\Carbon\Carbon::parse($item->published_at)->year }}/{{\Carbon\Carbon::parse($item->published_at)->month }}/{{$item->slug}}
@elseif (config('laravel-blog.permalink') == "year/month/day/slug")
  {{ config('laravel-blog.route') }}/{{\Carbon\Carbon::parse($item->published_at)->year }}/{{\Carbon\Carbon::parse($item->published_at)->month }}/{{\Carbon\Carbon::parse($item->published_at)->day }}/{{$item->slug}}
@elseif (config('laravel-blog.permalink') == "id")
  {{ config('laravel-blog.route') }}/{{$item->id}}
@else
  {{ config('laravel-blog.route') }}/{{$item->slug}}
@endif
