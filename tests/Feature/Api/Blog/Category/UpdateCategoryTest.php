<?php

namespace Tests\Feature\Api\Blog\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Covid\Blog\Models\Category;
use Covid\Blog\Format\CategoryFormat;
use Covid\Base\Models\User;

class UpdateCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $accessToken = null;
    protected $category = null;
    protected $category2 = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');

        $user = factory(User::class)->create();

        $response = $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => '123123',
        ]);

        $this->accessToken = $response->baseResponse->getData()->access_token;

        $this->category = factory(Category::class)->create();
        $this->category2 = factory(Category::class)->create();
    }

    /** @test */
    public function can_update_category()
    {
        $this->withoutExceptionHandling();

        $response = $this->putJson('api/blog/categories/' . $this->category->id, [
            'title' => 'Category title',
            'slug' => 'category-slug',
            'parent_id' => $this->category2->id,
            'meta_title' => 'Meta title',
            'meta_description' => 'Meta description',
            'description' => 'description',
            'thumbnail' => 'thumbnail',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $category = Category::find($this->category->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);

        $this->assertEquals('Category title', $category->title);
        $this->assertEquals('category-slug', $category->slug);
        $this->assertEquals('Meta title', $category->meta_title);
        $this->assertEquals('Meta description', $category->meta_description);
        $this->assertEquals('description', $category->description);
        $this->assertEquals('thumbnail', $category->thumbnail);
        $this->assertEquals($this->category2->id, $category->parent_id);
    }

    /** @test */
    public function can_reset_blog_category_thumbnail_seo_description_info_to_empty()
    {
        $response = $this->putJson('api/blog/categories/' . $this->category->id, [
            'meta_title' => '',
            'meta_description' => '',
            'description' => '',
            'thumbnail' => '',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);

        $category = $this->category->refresh();

        $this->assertEquals('', $category->meta_title);
        $this->assertEquals('', $category->meta_description);
        $this->assertEquals('', $category->thumbnail);
        $this->assertEquals('', $category->description);
    }

    /** @test */
    public function cannot_update_blog_category_with_invalid_title()
    {
        $response = $this->putJson('api/blog/categories/' . $this->category->id, [
            'title' => '',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $category = Category::find($this->category->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertEquals($this->category->title, $category->title);
    }

    /** @test */
    public function cannot_update_category_with_invalid_parent_id()
    {
        $response = $this->putJson('api/blog/categories/' . $this->category->id, [
            'parent_id' => 10,
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $category = Category::find($this->category->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertEquals($this->category->parent_id, $category->parent_id);
    }

    /** @test */
    public function category_title_cannot_include_special_characters()
    {
        $response = $this->putJson('api/blog/categories/' . $this->category->id, [
            'title' => '<h1>Category <strong>title</strong><h1>',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $category = Category::find($this->category->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);

        $this->assertEquals('Category title', $category->title);
    }

    /** @test */
    public function category_slug_is_somtimes_required()
    {
        $this->withoutExceptionHandling();

        $response = $this->putJson('api/blog/categories/' . $this->category->id, [
            'title' => 'New title',
            'slug' => '',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $category = Category::find($this->category->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertEquals($this->category->title, $category->title);
        $this->assertEquals($this->category->slug, $category->slug);
    }
}
