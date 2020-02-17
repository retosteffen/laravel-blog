<?php

namespace Retosteffen\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
  use HasSlug;
public $timestamps = false;
  protected $table='categories';

  protected $fillable = [
  'name',
];

  public function blog_posts() {
      return $this->hasMany('App\BlogPost');
    }


  public function getSlugOptions() : SlugOptions
  {
      return SlugOptions::create()
          ->generateSlugsFrom('name')
          ->saveSlugsTo('slug');
  }
  public function getRouteKeyName()
    {
        return 'slug';
    }




}
