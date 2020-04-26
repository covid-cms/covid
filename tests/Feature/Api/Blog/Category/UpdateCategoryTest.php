<?php

namespace Tests\Feature\Api\Blog\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Blog\Category;
use App\Format\Blog\CategoryFormat;
use App\Models\User;

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
        $this->assertEquals($this->category2->id, $category->parent_id);
    }

    /** @test */
    public function cannot_update_category_with_invalid_title()
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
    public function category_slug_is_slugly()
    {
        $this->withoutExceptionHandling();

        $response = $this->putJson('api/blog/categories/' . $this->category->id, [
            'slug' => 'This is a not slugly',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $category = Category::find($this->category->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);

        $this->assertEquals('this-is-a-not-slugly', $category->slug);
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
