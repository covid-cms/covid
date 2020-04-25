<?php

namespace Tests\Feature\Api\Blog\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Blog\Category;
use App\Format\Blog\CategoryFormat;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function category_can_be_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/blog/categories', [
            'title' => 'Category title',
            'slug' => 'category-slug',
        ]);

        $category = Category::first();

        $this->assertCount(1, Category::all());
        $this->assertEquals(0, $category->parent_id);
        $this->assertEquals('Category title', $category->title);
        $this->assertEquals('category-slug', $category->slug);

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
    public function category_cannot_create_with_empty_title()
    {
        $response = $this->post('/api/blog/categories', [
            'title' => '',
            'slug' => 'category-slug',
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
        $response = $this->post('/api/blog/categories', [
            'title' => 'Category title',
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
    public function category_slug_is_slugly()
    {
        $response = $this->post('/api/blog/categories', [
            'title' => 'Category title',
            'slug' => 'Category title',
        ]);

        $category = Category::first();
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

    /** @test */
    public function category_cannot_create_with_parent_is_not_exists()
    {
        $response = $this->post('/api/blog/categories', [
            'title' => 'Category title',
            'parent_id' => 10
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
        $response = $this->post('/api/blog/categories', [
            'title' => '<h1>Category</h1> title',
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
