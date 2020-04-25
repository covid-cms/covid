<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;

class SignupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_signup()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('api/auth/signup', [
            'email' => 'email@gmail.com',
            'name' => 'Pham Quang Binh',
            'password' => '123123',
        ]);

        $this->assertEquals(1, User::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);
    }

    /** @test */
    public function user_cannot_signup_with_empty_email()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('api/auth/signup', [
            'email' => '',
            'name' => 'Pham Quang Binh',
            'password' => '123123',
        ]);

        $this->assertEquals(0, User::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);
    }

    /** @test */
    public function user_cannot_signup_with_empty_password()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('api/auth/signup', [
            'email' => 'email@gmail.com',
            'name' => 'Pham Quang Binh',
            'password' => '',
        ]);

        $this->assertEquals(0, User::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);
    }

    /** @test */
    public function user_cannot_rergister_with_short_password()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('api/auth/signup', [
            'email' => 'email@gmail.com',
            'name' => 'Pham Quang Binh',
            'password' => '123',
        ]);

        $this->assertEquals(0, User::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);
    }

    /** @test */
    public function user_cannot_signup_with_existed_email()
    {
        $this->withoutExceptionHandling();

        $this->postJson('api/auth/signup', [
            'email' => 'email@gmail.com',
            'name' => 'Pham Quang Binh',
            'password' => '123123',
        ]);

        $response = $this->postJson('api/auth/signup', [
            'email' => 'email@gmail.com',
            'name' => 'Pham Quang Binh',
            'password' => '123123',
        ]);

        $this->assertEquals(1, User::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);
    }

    /** @test */
    public function user_cannot_signup_with_invalid_email()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('api/auth/signup', [
            'email' => 'emailgmail.com',
            'name' => 'Pham Quang Binh',
            'password' => '123',
        ]);

        $this->assertEquals(0, User::count());

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true,
            ]);
    }
}
