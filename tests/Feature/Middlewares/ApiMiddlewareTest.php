<?php

namespace Tests\Feature\Middlewares;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Blog\Category;

class ApiMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_cannot_use_blog_category_resource_if_not_login()
    {
        $this->postJson('api/blog/categories', [ 'title' => 'Title' ])->assertStatus(401);

        $category = factory(Category::class)->create();
        $this->putJson('api/blog/categories/' . $category->id, [ 'title' => 'Title' ])->assertStatus(401);
    }
}
