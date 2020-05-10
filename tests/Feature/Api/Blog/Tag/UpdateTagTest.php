<?php

namespace Tests\Feature\Api\Blog\Tag;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Blog\Tag;
use App\Format\Blog\TagFormat;
use App\Models\User;

class UpdateTagTest extends TestCase
{
    use RefreshDatabase;

    protected $accessToken = null;
    protected $tag = null;

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

        $this->tag = factory(Tag::class)->create();
    }

    /** @test */
    public function can_update_tag()
    {
        $this->withoutExceptionHandling();

        $response = $this->putJson('api/blog/tags/' . $this->tag->id, [
            'title' => 'Tag title',
            'slug' => 'tag-slug',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $tag = Tag::find($this->tag->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);

        $this->assertEquals('Tag title', $tag->title);
        $this->assertEquals('tag-slug', $tag->slug);
    }

    /** @test */
    public function cannot_update_tag_with_invalid_title()
    {
        $response = $this->putJson('api/blog/tags/' . $this->tag->id, [
            'title' => '',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $tag = Tag::find($this->tag->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertEquals($this->tag->title, $tag->title);
    }

    /** @test */
    public function tag_slug_is_slugly()
    {
        $this->withoutExceptionHandling();

        $response = $this->putJson('api/blog/tags/' . $this->tag->id, [
            'slug' => 'This is a not slugly',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $tag = Tag::find($this->tag->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);

        $this->assertEquals('this-is-a-not-slugly', $tag->slug);
    }

    /** @test */
    public function tag_title_cannot_include_special_characters()
    {
        $response = $this->putJson('api/blog/tags/' . $this->tag->id, [
            'title' => '<h1>Tag <strong>title</strong><h1>',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $tag = Tag::find($this->tag->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);

        $this->assertEquals('Tag title', $tag->title);
    }

    /** @test */
    public function tag_slug_is_somtimes_required()
    {
        $this->withoutExceptionHandling();

        $response = $this->putJson('api/blog/tags/' . $this->tag->id, [
            'title' => 'New title',
            'slug' => '',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $tag = Tag::find($this->tag->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);

        $this->assertEquals($this->tag->title, $tag->title);
        $this->assertEquals($this->tag->slug, $tag->slug);
    }
}
