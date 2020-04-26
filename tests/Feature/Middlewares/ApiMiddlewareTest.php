<?php

namespace Tests\Feature\Middlewares;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Blog\Category;
use App\Models\Blog\Tag;

class ApiMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_cannot_use_blog_category_resource_if_not_login()
    {
        $this->postJson('api/blog/categories', [ 'title' => 'Title' ])->assertStatus(401);
        $this->getJson('api/blog/categories')->assertStatus(401);

        $category = factory(Category::class)->create();
        $this->putJson('api/blog/categories/' . $category->id, [ 'title' => 'Title' ])->assertStatus(401);
        $this->deleteJson('api/blog/categories/' . $category->id)->assertStatus(401);
    }

        /** @test */
    public function user_cannot_use_blog_tag_resource_if_not_login()
    {
        $this->postJson('api/blog/tags', [ 'title' => 'Title' ])->assertStatus(401);
        $this->getJson('api/blog/tags')->assertStatus(401);

        $tag = factory(Tag::class)->create();
        $this->putJson('api/blog/tags/' . $tag->id, [ 'title' => 'Title' ])->assertStatus(401);
        $this->deleteJson('api/blog/tags/' . $tag->id)->assertStatus(401);
    }
}
