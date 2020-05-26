<?php

namespace Tests\Feature\Api\Blog\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Covid\Blog\Models\Category;
use Covid\Blog\Format\CategoryFormat;
use Covid\Base\Models\User;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $accessToken = null;

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
    }

    /** @test */
    public function can_create_category()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('/api/blog/categories', [
            'title' => 'Category title',
            'slug' => 'category-slug',
            'parent_id' => 0,
            'meta_title' => 'Meta title',
            'meta_description' => 'Meta description',
            'description' => 'description',
            'thumbnail' => 'thumbnail',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $category = Category::first();

        $this->assertCount(1, Category::all());
        $this->assertEquals(0, $category->parent_id);
        $this->assertEquals('Category title', $category->title);
        $this->assertEquals('category-slug', $category->slug);
        $this->assertEquals('Meta title', $category->meta_title);
        $this->assertEquals('Meta description', $category->meta_description);
        $this->assertEquals('description', $category->description);
        $this->assertEquals('thumbnail', $category->thumbnail);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'category' => $category->format(CategoryFormat::STANDARD)
                ]
            ]);
    }

    /** @test */
    public function can_create_category_with_parent_id()
    {
        $this->withoutExceptionHandling();

        $this->postJson('/api/blog/categories', [
            'title' => 'Parent title',
            'parent_id' => 0,
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $parentCategory = Category::first();

        $response = $this->postJson('/api/blog/categories', [
            'title' => 'Category title',
            'parent_id' => $parentCategory->id,
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $category = Category::where('id', '!=', $parentCategory->id)->first();

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'category' => $category->format(CategoryFormat::STANDARD)
                ]
            ]);

        $this->assertEquals($category->parent_id, $parentCategory->id);
    }

    /** @test */
    public function cannot_create_category_with_empty_title()
    {
        $response = $this->postJson('/api/blog/categories', [
            'title' => '',
            'slug' => 'category-slug',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $this->assertEquals(0, Category::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true
            ]);
    }

    /** @test */
    public function category_slug_is_automaticly_generate_from_title()
    {
        $response = $this->postJson('/api/blog/categories', [
            'title' => 'Category title',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $category = Category::first();
        $this->assertEquals('category-title', $category->slug);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'category' => $category->format(CategoryFormat::STANDARD)
                ]
            ]);
    }

    /** @test */
    public function  cannot_create_category_with_parent_is_not_exists()
    {
        $response = $this->postJson('/api/blog/categories', [
            'title' => 'Category title',
            'parent_id' => 10
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $this->assertEquals(0, Category::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true
            ]);
    }

    /** @test */
    public function category_cannot_create_with_parent_is_childs_it()
    {

    }

    /** @test */
    public function category_title_cannot_include_special_characters()
    {
        $response = $this->postJson('/api/blog/categories', [
            'title' => '<h1>Category</h1> title',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $category = Category::first();
        $this->assertEquals('Category title', $category->title);
        $this->assertEquals('category-title', $category->slug);
        $this->assertEquals(1, Category::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'category' => $category->format(CategoryFormat::STANDARD)
                ]
            ]);
    }
}
