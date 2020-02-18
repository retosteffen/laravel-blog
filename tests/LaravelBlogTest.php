<?php

namespace Retosteffen\LaravelBlog\Tests;

use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\TestCase;
use Retosteffen\LaravelBlog\LaravelBlogServiceProvider;
use Retosteffen\LaravelBlog\Models\Category;
use Retosteffen\LaravelBlog\Models\LaravelBlog;
use Spatie\Tags\Tag;

class LaravelBlogTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelBlogServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'laravel-blog' => 'Retosteffen\LaravelBlog',
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        require_once __DIR__.'/../database/migrations/create_blogs_table.php.stub';
        require_once __DIR__.'/../vendor/spatie/laravel-tags/database/migrations/create_tag_tables.php.stub';

        $this->loadLaravelMigrations();
        (new \CreateBlogsTable())->up();
        (new \CreateTagTables())->up();
    }

    /** @test */
    public function create_post()
    {
        $post = new LaravelBlog();
        $post->title = 'test';
        $post->content = 'test';
        $post->save();

        $database_post = LaravelBlog::find($post->id);

        $this->assertSame($database_post->title, 'test');
    }

    /** @test */
    public function blog_page()
    {
        $this->get('/blog')
    ->assertViewIs('laravel-blog::blog.index')
    ->assertViewHas('posts')
    ->assertStatus(200);
    }


    public function blog_post_page_slug()
    {

    //will fail because of App\User
        //to make it work replace: return $this->belongsTo('App\User','user_id');
        //with return $this->belongsTo('Retosteffen\LaravelBlog\Tests\TestUser','user_id');
        //in LaravelBlog model

        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $tag = new Tag();
        $tag->name = 'tag test';
        $tag->save();

        $post = new TestBlogPost();
        $post->title = 'test';
        $post->content = 'test';
        $post->published = 1;
        $post->published_at = date('Y-m-d H:i:s');
        $post->user_id = $user->id;
        $post->save();

        $post->syncTagsWithType([$tag]);

        $post2 = new TestBlogPost();
        $post2->title = 'test2';
        $post2->content = 'test';
        $post2->user_id = $user->id;
        $post2->save();

        $this->get('/blog/'.$post2->slug)
    ->assertStatus(404);

        $this->get('/blog/'.$post->slug)
    ->assertViewIs('laravel-blog::blog.show')
    ->assertViewHas('blogPost')
    ->assertStatus(200);

        config()->set('laravel-blog.permalink', 'id');
        $this->get('/blog/'.$post->slug)
    ->assertRedirect('/blog/'.$post->id);

        config()->set('laravel-blog.permalink', 'year/month/slug');
        $this->get('/blog/'.$post->slug)
    ->assertRedirect('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.$post->slug);

        config()->set('laravel-blog.permalink', 'year/month/day/slug');
        $this->get('/blog/'.$post->slug)
    ->assertRedirect('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.\Carbon\Carbon::parse($post->published_at)->day.'/'.$post->slug);
    }


    public function blog_post_page_id()
    {

    //will fail because of App\User
        //to make it work replace: return $this->belongsTo('App\User','user_id');
        //with return $this->belongsTo('Retosteffen\LaravelBlog\Tests\TestUser','user_id');
        //in LaravelBlog model

        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $tag = new Tag();
        $tag->name = 'tag test';
        $tag->save();

        $post = new TestBlogPost();
        $post->title = 'test';
        $post->content = 'test';
        $post->published = 1;
        $post->published_at = date('Y-m-d H:i:s');
        $post->user_id = $user->id;
        $post->save();

        $post->syncTagsWithType([$tag]);

        $post2 = new TestBlogPost();
        $post2->title = 'test2';
        $post2->content = 'test';
        $post2->user_id = $user->id;
        $post2->save();

        config()->set('laravel-blog.permalink', 'id');
        $this->get('/blog/'.$post2->id)
    ->assertStatus(404);

        $this->get('/blog/'.$post->id)
    ->assertViewIs('laravel-blog::blog.show')
    ->assertViewHas('blogPost')
    ->assertStatus(200);

        config()->set('laravel-blog.permalink', 'slug');
        $this->get('/blog/'.$post->id)
    ->assertRedirect('/blog/'.$post->slug);

        config()->set('laravel-blog.permalink', 'year/month/slug');
        $this->get('/blog/'.$post->id)
    ->assertRedirect('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.$post->slug);

        config()->set('laravel-blog.permalink', 'year/month/day/slug');
        $this->get('/blog/'.$post->id)
    ->assertRedirect('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.\Carbon\Carbon::parse($post->published_at)->day.'/'.$post->slug);
    }


    public function blog_post_page_year_month()
    {

    //will fail because of App\User
        //to make it work replace: return $this->belongsTo('App\User','user_id');
        //with return $this->belongsTo('Retosteffen\LaravelBlog\Tests\TestUser','user_id');
        //in LaravelBlog model

        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $tag = new Tag();
        $tag->name = 'tag test';
        $tag->save();

        $post = new TestBlogPost();
        $post->title = 'test';
        $post->content = 'test';
        $post->published = 1;
        $post->published_at = date('Y-m-d H:i:s');
        $post->user_id = $user->id;
        $post->save();

        $post->syncTagsWithType([$tag]);

        $post2 = new TestBlogPost();
        $post2->title = 'test2';
        $post2->content = 'test';
        $post2->user_id = $user->id;
        $post2->save();

        config()->set('laravel-blog.permalink', 'year/month/slug');
        $this->get('/blog/'.\Carbon\Carbon::parse($post2->published_at)->year.'/'.\Carbon\Carbon::parse($post2->published_at)->month.'/'.$post2->slug)
    ->assertStatus(404);

        $this->get('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.$post->slug)
    ->assertViewIs('laravel-blog::blog.show')
    ->assertViewHas('blogPost')
    ->assertStatus(200);

        config()->set('laravel-blog.permalink', 'id');
        $this->get('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.$post->slug)
    ->assertRedirect('/blog/'.$post->id);

        config()->set('laravel-blog.permalink', 'slug');
        $this->get('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.$post->slug)
    ->assertRedirect('/blog/'.$post->slug);

        config()->set('laravel-blog.permalink', 'year/month/day/slug');
        $this->get('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.$post->slug)
    ->assertRedirect('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.\Carbon\Carbon::parse($post->published_at)->day.'/'.$post->slug);
    }


    public function blog_post_page_year_month_day()
    {

    //will fail because of App\User
        //to make it work replace: return $this->belongsTo('App\User','user_id');
        //with return $this->belongsTo('Retosteffen\LaravelBlog\Tests\TestUser','user_id');
        //in LaravelBlog model

        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $tag = new Tag();
        $tag->name = 'tag test';
        $tag->save();

        $post = new TestBlogPost();
        $post->title = 'test';
        $post->content = 'test';
        $post->published = 1;
        $post->published_at = date('Y-m-d H:i:s');
        $post->user_id = $user->id;
        $post->save();

        $post->syncTagsWithType([$tag]);

        $post2 = new TestBlogPost();
        $post2->title = 'test2';
        $post2->content = 'test';
        $post2->user_id = $user->id;
        $post2->save();

        config()->set('laravel-blog.permalink', 'year/month/day/slug');
        $this->get('/blog/'.\Carbon\Carbon::parse($post2->published_at)->year.'/'.\Carbon\Carbon::parse($post2->published_at)->month.'/'.\Carbon\Carbon::parse($post2->published_at)->day.'/'.$post2->slug)
    ->assertStatus(404);

        $this->get('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.\Carbon\Carbon::parse($post->published_at)->day.'/'.$post->slug)
    ->assertViewIs('laravel-blog::blog.show')
    ->assertViewHas('blogPost')
    ->assertStatus(200);

        config()->set('laravel-blog.permalink', 'id');
        $this
    ->get('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.\Carbon\Carbon::parse($post->published_at)->day.'/'.$post->slug)
    ->assertRedirect('/blog/'.$post->id);

        config()->set('laravel-blog.permalink', 'year/month/slug');
        $this
    ->get('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.\Carbon\Carbon::parse($post->published_at)->day.'/'.$post->slug)
    ->assertRedirect('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.$post->slug);

        config()->set('laravel-blog.permalink', 'slug');
        $this
    ->get('/blog/'.\Carbon\Carbon::parse($post->published_at)->year.'/'.\Carbon\Carbon::parse($post->published_at)->month.'/'.\Carbon\Carbon::parse($post->published_at)->day.'/'.$post->slug)
    ->assertRedirect('/blog/'.$post->slug);
    }

    /** @test */
    public function create_blog_page()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $this->actingAs($user)
    ->get('/blog/create')
    ->assertViewIs('laravel-blog::blog.create')
    ->assertStatus(200);
    }

    /** @test */
    public function create_blog_page_anonymous()
    {
        $this
    ->get('/blog/create')
    ->assertStatus(500);
    }

    /** @test */
    public function edit_blog_page()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);
        $post = new TestBlogPost();
        $post->title = 'test';
        $post->content = 'test';
        $post->user_id = $user->id;
        $post->save();

        $this->actingAs($user)
    ->get('/blog/test/edit')
    ->assertViewIs('laravel-blog::blog.edit')
    ->assertStatus(200);
    }

    /** @test */
    public function edit_blog_page_anonymous()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $post = new TestBlogPost();
        $post->title = 'test';
        $post->content = 'test';
        $post->user_id = $user->id;
        $post->save();

        $this
    ->get('/blog/test/edit')
    ->assertStatus(500);
    }

    /** @test */
    public function create_tag()
    {
        $post = new Tag();
        $post->name = 'tag test';
        $post->save();
        $database_post = Tag::find($post->id);

        $this
    ->assertSame($database_post->name, 'tag test');
    }

    /** @test */
    public function create_tag_page()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $this
    ->actingAs($user)
    ->get('/blog_admin/tags/create')
    ->assertViewIs('laravel-blog::tag.create')
    ->assertStatus(200);
    }

    /** @test */
    public function post_tag()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $response = $this->actingAs($user)->json('POST', '/blog_admin/tags', ['name' => 'testtag']);

        $database_tag = Tag::find(1);

        $this->assertSame($database_tag->name, 'testtag');

        $response
    ->assertStatus(302)
    ->assertRedirect('/blog_admin/tags');
    }

    /** @test */
    public function update_tag()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $post = new Tag();
        $post->name = 'tag test';
        $post->save();

        $database_post = Tag::find($post->id);

        $this
    ->assertSame($database_post->name, 'tag test');

        $response = $this->actingAs($user)->json('PATCH', '/blog_admin/tags/'.$post->id, ['name' => 'testtag']);

        $database_tag = Tag::find($post->id);

        $this->assertSame($database_tag->name, 'testtag');

        $response
    ->assertStatus(302)
    ->assertRedirect('/blog_admin/tags');
    }

    /** @test */
    public function delete_tag()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $post = new Tag();
        $post->name = 'tag test';
        $post->save();

        $database_post = Tag::find($post->id);

        $this
    ->assertSame($database_post->name, 'tag test');

        $response = $this->actingAs($user)->json('DELETE', '/blog_admin/tags/'.$post->id);

        $this->assertDeleted($database_post);

        $response
    ->assertStatus(302)
    ->assertRedirect('/blog_admin/tags');
    }

    /** @test */
    public function edit_tag_page()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $post = new Tag();
        $post->name = 'tagtest';
        $post->save();

        $this->actingAs($user)
    ->get('/blog_admin/tags/'.$post->id.'/edit')
    ->assertViewIs('laravel-blog::tag.edit')
    ->assertStatus(200);
    }

    /** @test */
    public function create_tag_page_anonymous()
    {
        $this
    ->get('/blog_admin/tags/create')
    ->assertStatus(500);
    }

    /** @test */
    public function edit_tag_page_anonymous()
    {
        $post = new Tag();
        $post->name = 'tagtest';
        $post->save();

        $this
    ->get('/blog_admin/tags/'.$post->id.'/edit')
    ->assertStatus(500);
    }

    /** @test */
    public function tag_index()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $this
    ->actingAs($user)
    ->get('/blog_admin/tags')
    ->assertViewIs('laravel-blog::tag.index')
    ->assertStatus(200);
    }

    /** @test */
    public function tag_index_anonymous()
    {
        $this
    ->get('/blog_admin/tags')
    ->assertStatus(500);
    }

    /** @test */
    public function tag_show()
    {
        $post = new Tag();
        $post->name = 'tagtest';
        $post->save();

        $this
    ->get('/blog/tag/'.$post->slug)
    ->assertViewIs('laravel-blog::archive')
    ->assertStatus(200);
    }

    /** @test */
    public function create_category()
    {
        $post = new Category();
        $post->name = 'category test';
        $post->save();

        $database_post = Category::find($post->id);

        $this->assertSame($database_post->name, 'category test');
    }

    /** @test */
    public function create_category_page()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $this
    ->actingAs($user)
    ->get('/blog_admin/categories/create')
    ->assertViewIs('laravel-blog::category.create')
    ->assertStatus(200);
    }

    /** @test */
    public function post_category()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $response = $this->actingAs($user)->json('POST', '/blog_admin/categories', ['name' => 'testcategory']);

        $database_tag = Category::find(1);

        $this->assertSame($database_tag->name, 'testcategory');

        $response
    ->assertStatus(302)
    ->assertRedirect('/blog_admin/categories');
    }

    /** @test */
    public function update_category()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $post = new Category();
        $post->name = 'category test';
        $post->save();

        $database_post = Category::find($post->id);

        $this
    ->assertSame($database_post->name, 'category test');

        $response = $this->actingAs($user)->json('PATCH', '/blog_admin/categories/'.$post->slug, ['name' => 'testcategory']);

        $database_tag = Category::find($post->id);

        $this->assertSame($database_tag->name, 'testcategory');

        $response
    ->assertStatus(302)
    ->assertRedirect('/blog_admin/categories');
    }

    /** @test */
    public function delete_category()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $post = new Category();
        $post->name = 'category test';
        $post->save();

        $database_post = Category::find($post->id);

        $this
    ->assertSame($database_post->name, 'category test');

        $response = $this->actingAs($user)->json('DELETE', '/blog_admin/categories/'.$post->slug);

        $this->assertDeleted($database_post);

        $response
    ->assertStatus(302)
    ->assertRedirect('/blog_admin/categories');
    }

    /** @test */
    public function edit_category_page()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $post = new Category();
        $post->name = 'tagtest';
        $post->save();

        $this->actingAs($user)
    ->get('/blog_admin/categories/'.$post->slug.'/edit')
    ->assertViewIs('laravel-blog::category.edit')
    ->assertStatus(200);
    }

    /** @test */
    public function create_category_page_anonymous()
    {
        $this
    ->get('/blog_admin/categories/create')
    ->assertStatus(500);
    }

    /** @test */
    public function edit_category_page_anonymous()
    {
        $post = new Category();
        $post->name = 'tagtest';
        $post->save();

        $this
    ->get('/blog_admin/categories/'.$post->id.'/edit')
    ->assertStatus(500);
    }

    /** @test */
    public function category_index()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $this
    ->actingAs($user)
    ->get('/blog_admin/categories')
    ->assertViewIs('laravel-blog::category.index')
    ->assertStatus(200);
    }

    /** @test */
    public function category_index_anonymous()
    {
        $this
    ->get('/blog_admin/categories')
    ->assertStatus(500);
    }

    /** @test */
    public function category_show()
    {
        $post = new Category();
        $post->name = 'tagtest';
        $post->save();

        $this
    ->get('/blog/category/'.$post->slug)
    ->assertViewIs('laravel-blog::archive')
    ->assertStatus(200);
    }



    public function post_blog()
    {
      //will fail because of App\User
      //to make it work replace: return $this->belongsTo('App\User','user_id');
      //with return $this->belongsTo('Retosteffen\LaravelBlog\Tests\TestUser','user_id');
      //in LaravelBlog model
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $response = $this->actingAs($user)->json('POST', '/blog', ['title' => 'test', 'content'=>'test']);

        $database_post = TestBlogPost::find(1);

        $this->assertSame($database_post->title, 'test');

        $response
    ->assertStatus(302)
    ->assertRedirect('/blog_admin');
    }

    /** @test */
    public function update_blog()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $post = new TestBlogPost();
        $post->title = 'test';
        $post->content = 'test';
        $post->user_id = $user->id;
        $post->save();

        $database_post = TestBlogPost::find($post->id);

        $this
    ->assertSame($database_post->title, 'test');

        $response = $this->actingAs($user)->json('PATCH', '/blog/'.$post->slug, ['title' => 'test2', 'content'=>'test']);

        $database_tag = TestBlogPost::find($post->id);

        $this->assertSame($database_tag->title, 'test2');

        $response
    ->assertStatus(302)
    ->assertRedirect('/blog_admin');
    }

    /** @test */
    public function delete_blog()
    {
        $user = TestUser::create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $post = new TestBlogPost();
        $post->title = 'test';
        $post->content = 'test';
        $post->user_id = $user->id;
        $post->save();

        $database_post = TestBlogPost::find($post->id);
        $this
    ->assertSame($database_post->title, 'test');
        $response = $this->actingAs($user)->json('DELETE', '/blog/'.$post->slug);

        $this->assertDeleted($database_post);

        $response
    ->assertStatus(302)
    ->assertRedirect('/blog_admin');
    }


    public function blog_author_show()
    {

    //will fail because of App\User
        //to make it work replace $item=User::where('name','=',$user_name)->first();
        //with $item=\Retosteffen\LaravelBlog\Tests\TestUser::where('name','=',$user_name)->first();
        //in LaravelBlogController@indexAuthor

        $user = TestUser::create([
            'name'=>'testauthor',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $post = new TestBlogPost();
        $post->title = 'test';
        $post->content = 'test';
        $post->user_id = $user->id;
        $post->published = 1;
        $post->published_at = date('Y-m-d H:i:s');
        $post->save();

        $this
    ->get('/blog/author/'.$user->name)
    ->assertViewIs('laravel-blog::archive')
    ->assertStatus(200);
    }

    /** @test */
    public function blog_previous_and_next_post()
    {
        $user = TestUser::create([
            'name'=>'testauthor',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $post = new TestBlogPost();
        $post->title = 'test';
        $post->content = 'test';
        $post->user_id = $user->id;
        $post->published = 1;
        $post->published_at = date('Y-m-d H:i:s');
        $post->save();

        $post2 = new TestBlogPost();
        $post2->title = 'test2';
        $post2->content = 'test';
        $post2->user_id = $user->id;
        $post2->published = 1;

        $time = new \DateTime();
        $time->add(new \DateInterval('PT10M'));

        $post2->published_at = $time->format('Y-m-d H:i:s');
        $post2->save();

        $database_post1 = TestBlogPost::find($post->id);
        $database_post2 = TestBlogPost::find($post2->id);

        $this
    ->assertSame($database_post2->previousItem()->id, $database_post1->id);

        $this
    ->assertSame($database_post1->nextItem()->id, $database_post2->id);
    }

    /** @test */
    public function category_has_posts()
    {
        $user = TestUser::create([
            'name'=>'testauthor',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $category = new TestCategory();
        $category->name = 'category test';
        $category->save();

        $post = new TestBlogPost();
        $post->title = 'test';
        $post->content = 'test';
        $post->category_id = $category->id;
        $post->user_id = $user->id;
        $post->published = 1;
        $post->published_at = date('Y-m-d H:i:s');
        $post->save();

        $post2 = new TestBlogPost();
        $post2->title = 'test2';
        $post2->content = 'test';
        $post2->category_id = $category->id;
        $post2->user_id = $user->id;
        $post2->published = 1;
        $time = new \DateTime();
        $time->add(new \DateInterval('PT10M'));
        $post2->published_at = $time->format('Y-m-d H:i:s');
        $post2->save();

        $posts = TestBlogPost::all();

        $this
    ->assertTrue($category->blog_posts->contains('id', $post->id));
        $this
    ->assertTrue($category->blog_posts->contains('id', $post2->id));
    }

    /** @test */
    public function blog_admin_show()
    {
        $user = TestUser::create([
            'name'=>'testauthor',
            'email'=>'test@test.com',
            'password'=>'secret',
        ]);

        $this
    ->actingAs($user)
    ->get('/blog_admin')
    ->assertViewIs('laravel-blog::blog_admin')
    ->assertStatus(200);
    }

    /** @test */
    public function blog_admin_show_anonymous()
    {
        $this
    ->get('/blog_admin')
    ->assertStatus(500);
    }
}

class TestUser extends User
{
    protected $guarded = [];
    protected $table = 'users';
}

class TestBlogPost extends LaravelBlog
{
    protected $table = 'blogs';

    public function author()
    {
        return $this->belongsTo('Retosteffen\LaravelBlog\Tests\TestUser', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('Retosteffen\LaravelBlog\Tests\TestCategory', 'category_id');
    }
}

class TestCategory extends Category
{
    protected $table = 'categories';

    public function blog_posts()
    {
        return $this->hasMany('Retosteffen\LaravelBlog\Tests\TestBlogPost', 'category_id', 'id');
    }
}
