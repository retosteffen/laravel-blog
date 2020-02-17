# Simple blog for your laravel application

[![Latest Version on Packagist](https://img.shields.io/packagist/v/retosteffen/laravel-blog.svg?style=flat-square)](https://packagist.org/packages/retosteffen/laravel-blog)
[![Build Status](https://img.shields.io/travis/retosteffen/laravel-blog/master.svg?style=flat-square)](https://travis-ci.org/retosteffen/laravel-blog)
[![Quality Score](https://img.shields.io/scrutinizer/g/retosteffen/laravel-blog.svg?style=flat-square)](https://scrutinizer-ci.com/g/retosteffen/laravel-blog)
[![Total Downloads](https://img.shields.io/packagist/dt/retosteffen/laravel-blog.svg?style=flat-square)](https://packagist.org/packages/retosteffen/laravel-blog)

If you need to add a simple blog to an existing laravel application this might be for you. Views are kept very barebones on purpose so that you can easily add your existing styles.

Any registered user of your app will be able to add/edit/delete blog posts, categories and tags.

SEO for blog post should be ok

This package is **not** a full laravel application! It only allows you to add a simple blog to the laravel application that you already have.

## Installation

You can install the package via composer:

add this to your composer.json
```bash
{
    "type": "vcs",
    "url": "https://github.com/retosteffen/laravel-tags"
}
```

```bash
composer require retosteffen/laravel-blog
```

requires laravel auth
https://laravel.com/docs/6.x/authentication


included packages (will be added automatically)
```bash
"spatie/laravel-sluggable": "^2.2",
"spatie/laravel-tags": "dev-master",
"laravel/helpers": "^1.1",
```
more info about those packages here:

https://github.com/spatie/laravel-sluggable

https://github.com/spatie/laravel-tags

note: This packages uses a slighty modified version of spatie/laravel-tags


### Migrations
```bash
php artisan vendor:publish --provider="Spatie\Tags\TagsServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Retosteffen\LaravelBlog\LaravelBlogServiceProvider" --tag="laravel-blog:migrations"
php artisan migrate
```


### Views
The views are very barebones so you will probably want to edit them and add your own styles
```bash
php artisan vendor:publish --provider="Retosteffen\LaravelBlog\LaravelBlogServiceProvider" --tag="laravel-blog:views"
```
layout.blade.php template is easily editable to fit the style of your application but should include:
``` php
<title>@yield('title')</title>
@yield('meta')
@yield('content')
@yield('javascript')
```

### Translations
Translations for french and german are included.

```bash
php artisan vendor:publish --provider="Retosteffen\LaravelBlog\LaravelBlogServiceProvider" --tag="laravel-blog:lang"
```





## Config
To configure the path of the blog and the permalink structure
```bash
php artisan vendor:publish --provider="Retosteffen\LaravelBlog\LaravelBlogServiceProvider" --tag="laravel-blog:config"
```

```bash
return [
  'route' => "/blog",
  'adminroute' => "/blog_admin",
  'blog_name'=>'My blog',
  'permalink' => "slug", //options are id, year/month/slug, year/month/day/slug, slug
  'locale'=>'en_US',
  'facebook_name'=>"YOUR FACEBOOK PAGE URL",
  'twitter_handle'=>"YOUR TWITTER HANDLE"
];
```


## Usage

Public view of the blog will be at /blog

Registered users will be able to access /blog_admin and create/edit/delete new blog posts, categories and tags





### Testing

``` bash
composer test
```
some test will fail because they require App\User which isn't included.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email retosteffen@mac.com instead of using the issue tracker.

## Credits

- [Reto Steffen](https://github.com/retosteffen)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
