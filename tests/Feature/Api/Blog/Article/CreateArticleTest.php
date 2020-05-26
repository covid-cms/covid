<?php

namespace Tests\Feature\Api\Blog\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Covid\Blog\Models\Article;
use Covid\Blog\Models\Category;
use Covid\Blog\Models\Tag;
use Covid\Blog\Format\ArticleFormat;
use Covid\Base\Models\User;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    protected $accessToken = null;
    protected $tags = null;
    protected $categories = null;
    protected $user = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');

        $this->tags = factory(Tag::class, 3)->create();
        $this->categories = factory(Category::class, 3)->create();

        $this->user = factory(User::class)->create();

        $response = $this->postJson('api/auth/login', [
            'email' => $this->user->email,
            'password' => '123123',
        ]);

        $this->accessToken = $response->baseResponse->getData()->access_token;
    }

    /** @test */
    public function can_create_article()
    {
        // $this->withoutExceptionHandling();

        $categories = $this->categories->random(2);
        $tags = $this->tags->random(2);
        $categoriesId = $categories->pluck('id')->toArray();
        $tagsId = $tags->pluck('id')->toArray();

        $response = $this->postJson('/api/blog/articles', [
            'title' => 'Article title',
            'content' => 'content',
            'thumbnail' => 'thumbnail',
            'categories' => $categoriesId,
            'tags' => $tagsId,
            'slug' => 'article-slug',
            'meta_title' => 'Meta title',
            'meta_description' => 'Meta description',
            'status' => 'published'
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $article = Article::first();

        $this->assertEquals(1, Article::count());
        $this->assertEquals('Article title', $article->title);
        $this->assertEquals('article-slug', $article->slug);
        $this->assertEquals('Meta title', $article->meta_title);
        $this->assertEquals('Meta description', $article->meta_description);
        $this->assertEquals('content', $article->content);
        $this->assertEquals('thumbnail', $article->thumbnail);
        $this->assertEquals($article->tags()->count(), count($tagsId));
        $this->assertEquals($article->categories()->count(), count($categoriesId));

        foreach ($article->categories as $category) {
            $this->assertTrue(in_array($category->id, $categoriesId));
        }

        foreach ($article->tags as $tag) {
            $this->assertTrue(in_array($tag->id, $tagsId));
        }

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'article' => $article->format(ArticleFormat::STANDARD)
                ]
            ]);
    }

    /** @test */
    public function can_create_empty_article()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('/api/blog/articles', [
            'title' => 'Article title',
            'slug' => '',
            'content' => '',
            'thumbnail' => '',
            'categories' => '',
            'tags' => '',
            'meta_title' => '',
            'meta_description' => '',
            'status' => Article::STATUS_DRAFT,
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $article = Article::first();

        $this->assertEquals(1, Article::count());
        $this->assertEquals('Article title', $article->title);
        $this->assertEquals('article-title', $article->slug);
        $this->assertEquals('', $article->meta_title);
        $this->assertEquals('', $article->meta_description);
        $this->assertEquals('', $article->content);
        $this->assertEquals('', $article->thumbnail);
        $this->assertEquals($this->user->id, $article->author_id);
        $this->assertEquals(Article::STATUS_DRAFT, $article->status);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'article' => $article->format(ArticleFormat::STANDARD)
                ]
            ]);
    }

    /** @test */
    public function article_slug_is_automaticly_generate_from_title()
    {
        $response = $this->postJson('/api/blog/articles', [
            'title' => 'Article title',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $article = Article::first();
        $this->assertEquals('article-title', $article->slug);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'article' => $article->format(ArticleFormat::STANDARD)
                ]
            ]);
    }

    /** @test */
    public function article_slug_is_unique()
    {
        // $this->withoutExceptionHandling();

        $this->postJson('/api/blog/articles', [
            'title' => 'Article title',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $this->postJson('/api/blog/articles', [
            'title' => 'Article title',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $response = $this->postJson('/api/blog/articles', [
            'title' => 'Article title',
            'slug' => 'article-title',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $this->assertEquals(1, Article::count());

        $response->assertJson([
            'error' => true,
        ]);
    }

    /** @test */
    public function article_title_cannot_include_special_characters()
    {
        $response = $this->postJson('/api/blog/articles', [
            'title' => '<h1>Article</h1> title',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $article = Article::first();
        $this->assertEquals('Article title', $article->title);
        $this->assertEquals('article-title', $article->slug);
        $this->assertEquals(1, Article::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'article' => $article->format(ArticleFormat::STANDARD)
                ]
            ]);
    }
}
