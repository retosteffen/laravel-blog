<?php

namespace Retosteffen\LaravelBlog;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Retosteffen\LaravelBlog\Skeleton\SkeletonClass
 */
class LaravelBlogFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-blog';
    }
}
