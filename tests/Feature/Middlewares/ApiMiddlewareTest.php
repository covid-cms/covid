<?php

namespace Tests\Feature\Middlewares;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ApiMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_cannot_use_blog_category_resource_if_not_login($value='')
    {
        $this->postJson('api/blog/categories', [ 'title' => 'Title' ])->assertStatus(401);
    }
}
