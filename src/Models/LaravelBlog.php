<?php

namespace Retosteffen\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class LaravelBlog extends Model
{
    use HasSlug;
    use HasTags;

    protected $table = 'blogs';

    protected $guarded = ['user_id', 'slug', 'created_at', 'updated_at'];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('Retosteffen\LaravelBlog\Models\Category', 'category_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
    ->generateSlugsFrom('title')
    ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function nextItem()
    {
        $nextItem = self::where('published', '=', true)->where('published_at', '>', $this->published_at)->orderBy('published_at')->first();

        return $nextItem;
    }

    public function previousItem()
    {
        $previousItem = self::where('published', '=', true)->where('published_at', '<', $this->published_at)->orderBy('published_at')->first();

        return $previousItem;
    }
}
