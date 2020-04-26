<?php

namespace Tests\Feature\Api\Blog\Tag;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Blog\Tag;
use App\Format\Blog\TagFormat;
use App\Models\User;

class ListTagTest extends TestCase
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

        $this->tag = factory(Tag::class, 10)->create();
    }

    /** @test */
    public function can_listing_tag()
    {
        $this->withoutExceptionHandling();

        $response = $this->getJson('api/blog/tags', [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $response->assertStatus(200)->assertJson(['error' => false]);
    }
}
