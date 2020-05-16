<?php

namespace Tests\Feature\Api\Blog\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Blog\Article;
use App\Models\Blog\Category;
use App\Models\Blog\Tag;
use App\Format\Blog\ArticleFormat;
use App\Models\User;

class CreateUpdateTest extends TestCase
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
        $this->categories = factory(Category::class, 5)->create();
        $this->user = factory(User::class)->create();
        $this->article = factory(Article::class)->create();
        $this->article->categories()->sync($this->categories->pluck('id'));
        $this->article->tags()->sync($this->tags->pluck('id'));
        $this->accessToken = $this->user->createToken('Personal Access Token')->accessToken;
    }

    /** @test */
    public function can_update_blog_article()
    {
        $this->withoutExceptionHandling();

        $categories = $this->categories->random(2);
        $tags = $this->tags->random(2);
        $categoriesId = $categories->pluck('id')->toArray();
        $tagsId = $tags->pluck('id')->toArray();

        $response = $this->putJson('/api/blog/articles/' . $this->article->id, [
            'title' => 'Article title',
            'slug' => 'article-title-slug',
            'content' => 'content',
            'thumbnail' => 'thumbnail',
            'categories' => $categoriesId,
            'tags' => $tagsId,
            'meta_title' => 'Meta title',
            'meta_description' => 'Meta description',
            'status' => 'published'
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $article = $this->article->refresh();

        $this->assertEquals('Article title', $article->title);
        $this->assertEquals('article-title-slug', $article->slug);
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
    public function can_reset_blog_article_thumbnail_seo_info_to_empty()
    {
        $this->withoutExceptionHandling();

        $categories = $this->categories->random(2);
        $tags = $this->tags->random(2);
        $categoriesId = $categories->pluck('id')->toArray();
        $tagsId = $tags->pluck('id')->toArray();

        $response = $this->putJson('/api/blog/articles/' . $this->article->id, [
            'thumbnail' => null,
            'meta_title' => null,
            'meta_description' => null,
            'categories' => null,
            'tags' => null,
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $article = $this->article->refresh();

        $this->assertEquals('', $article->meta_title);
        $this->assertEquals('', $article->meta_description);
        $this->assertEquals('', $article->thumbnail);
        $this->assertEquals(0, $article->categories->count());
        $this->assertEquals(0, $article->tags->count());

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
