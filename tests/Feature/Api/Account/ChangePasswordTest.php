<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;

class ChangePasswordTest extends TestCase
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
    public function can_change_account_password()
    {
        $this->withoutExceptionHandling();

        $changePasswordResponse = $this->putJson('/api/account/password', [
            'password' => '123123',
            'password_confirmation' => '123123',
        ], [
            'Authorization' => "Bearer $this->accessToken"
        ]);

        $changePasswordResponse
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);
    }
}
