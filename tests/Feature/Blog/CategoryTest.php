<?php

namespace Tests\Feature\Blog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Blog\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_category_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->post('/api/blog/categories', [
            'title' => 'Category title',
            'slug' => 'category-title-slug'
        ]);

        $category = Category::first();
        $this->assertCount(1, Category::all());

        $this->assertEquals('Category title', $category->title);
        $this->assertEquals('category-title-slug', $category->title);
    }
}
