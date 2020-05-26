<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Covid\Base\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login()
    {
        $this->artisan('passport:install');

        $this->postJson('api/auth/signup', [
            'email' => 'email@gmail.com',
            'password' => '123123',
            'name' => 'Pham Quang Binh',
        ]);

        $response = $this->postJson('api/auth/login', [
            'email' => 'email@gmail.com',
            'password' => '123123'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ])
            ->assertJsonStructure([
                'error',
                'access_token',
            ]);
    }

    /** @test */
    public function user_can_not_login_with_account_not_exists()
    {
        $this->artisan('passport:install');

        $this->postJson('api/auth/signup', [
            'email' => 'email@gmail.com',
            'password' => '123123',
            'name' => 'Pham Quang Binh',
        ]);

        $response = $this->postJson('api/auth/login', [
            'email' => 'email@gmail.com',
            'password' => '1231234'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);
    }

    /** @test */
    public function user_cannot_login_with_invalid_email()
    {
        $this->artisan('passport:install');

        $response = $this->postJson('api/auth/login', [
            'email' => 'emailgmail.com',
            'password' => '123123'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);
    }

    /** @test */
    public function user_cannot_login_with_empty_email()
    {
        $this->artisan('passport:install');

        $response = $this->postJson('api/auth/login', [
            'email' => '',
            'password' => '123123'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);
    }

    /** @test */
    public function user_cannot_login_with_empty_password()
    {
        $this->artisan('passport:install');

        $response = $this->postJson('api/auth/login', [
            'email' => 'email@gmail.com',
            'password' => ''
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);
    }
}
