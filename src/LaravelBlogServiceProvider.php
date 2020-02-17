<?php

namespace Retosteffen\LaravelBlog;


use Illuminate\Support\ServiceProvider;

class LaravelBlogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-blog');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-blog');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-blog.php'),
            ], 'laravel-blog:config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-blog'),
            ], 'laravel-blog:views');


          if (! class_exists('CreateBlogsTable')) {
          $this->publishes([
              __DIR__.'/../database/migrations/create_blogs_table.php.stub' => database_path('migrations/'.date('Y_m_d_His',time()).'_create_blogs_table.php'),
          ], 'laravel-blog:migrations');
        }

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-blog'),
            ], 'assets');*/

            // Publishing the translation files.
            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-blog'),
            ], 'laravel-blog:lang');

            // Registering package commands.
            // $this->commands([]);
        }

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-blog');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-blog', function () {
            return new LaravelBlog;
        });
    }
}
