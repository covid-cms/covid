<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;

class UpdateAccountTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');

        $this->user = factory(User::class)->create();
        $this->accessToken = $this->user->createToken('Personal Access Token')->accessToken;
    }

    /** @test */
    public function can_update_account_info()
    {
        $this->withoutExceptionHandling();

        $response = $this->putJson('/api/account', [
            'name' => 'Pham Quang Binh'
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $response->assertStatus(200);

        $this->user->refresh();

        $this->assertEquals($this->user->name, 'Pham Quang Binh');
    }

    /** @test */
    public function cannot_update_name_is_empty()
    {
        $this->withoutExceptionHandling();

        $oldName = $this->user->name;

        $response = $this->putJson('/api/account', [
            'name' => ''
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);

        $user = $this->user->refresh();
        $this->assertEquals($oldName, $user->name);
    }
}
