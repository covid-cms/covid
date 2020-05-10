<?php

namespace Tests\Feature\Api\Blog\Tag;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Blog\Tag;
use App\Format\Blog\TagFormat;
use App\Models\User;

class CreateTagTest extends TestCase
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
    }

    /** @test */
    public function can_create_tag()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('/api/blog/tags', [
            'title' => 'Tag title',
            'slug' => 'tag-slug',
            'meta_title' => 'Meta title',
            'meta_description' => 'Meta description',
            'description' => 'description',
            'thumbnail' => 'thumbnail',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $tag = Tag::first();

        $this->assertCount(1, Tag::all());
        $this->assertEquals(0, $tag->parent_id);
        $this->assertEquals('Tag title', $tag->title);
        $this->assertEquals('tag-slug', $tag->slug);
        $this->assertEquals('Meta title', $tag->meta_title);
        $this->assertEquals('Meta description', $tag->meta_description);
        $this->assertEquals('description', $tag->description);
        $this->assertEquals('thumbnail', $tag->thumbnail);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'tag' => $tag->format(TagFormat::STANDARD)
                ]
            ]);
    }

    /** @test */
    public function cannot_create_tag_with_empty_title()
    {
        $response = $this->postJson('/api/blog/tags', [
            'title' => '',
            'slug' => 'tag-slug',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $this->assertEquals(0, Tag::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true
            ]);
    }

    /** @test */
    public function tag_slug_is_automaticly_generate_from_title()
    {
        $response = $this->postJson('/api/blog/tags', [
            'title' => 'Tag title',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $tag = Tag::first();
        $this->assertEquals('tag-title', $tag->slug);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'tag' => $tag->format(TagFormat::STANDARD)
                ]
            ]);
    }

    /** @test */
    public function tag_slug_is_slugly()
    {
        $response = $this->postJson('/api/blog/tags', [
            'title' => 'Tag title',
            'slug' => 'Tag title',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $tag = Tag::first();
        $this->assertEquals('tag-title', $tag->slug);
        $this->assertEquals(1, Tag::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'tag' => $tag->format(TagFormat::STANDARD)
                ]
            ]);
    }


    /** @test */
    public function tag_title_cannot_include_special_characters()
    {
        $response = $this->postJson('/api/blog/tags', [
            'title' => '<h1>Tag</h1> title',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $tag = Tag::first();
        $this->assertEquals('Tag title', $tag->title);
        $this->assertEquals('tag-title', $tag->slug);
        $this->assertEquals(1, Tag::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
                'data' => [
                    'tag' => $tag->format(TagFormat::STANDARD)
                ]
            ]);
    }
}
