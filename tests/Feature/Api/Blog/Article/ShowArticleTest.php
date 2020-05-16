<?php

namespace Tests\Feature\Api\Blog\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Blog\Article;
use App\Format\Blog\ArticleFormat;
use App\Models\User;

class ShowArticleTest extends TestCase
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

        $this->article = factory(Article::class)->create();
    }

    /** @test */
    public function can_show_detail_article()
    {
        $this->withoutExceptionHandling();

        $response = $this->getJson('api/blog/articles/' . $this->article->id, [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $response->assertStatus(200)->assertJson(['error' => false]);
    }
}