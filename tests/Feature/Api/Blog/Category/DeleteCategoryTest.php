<?php

namespace Tests\Feature\Api\Blog\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Blog\Category;
use App\Models\User;

class DeleteCategoryTest extends TestCase
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

        $this->category = factory(Category::class)->create();
    }

    /** @test */
    public function can_delete_category()
    {
        $this->withoutExceptionHandling();

        $response = $this->deleteJson('api/blog/categories/' . $this->category->id, [], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $response->assertStatus(200)->assertJson(['error' => false]);
        $this->assertEquals(0, Category::count());
    }
}
