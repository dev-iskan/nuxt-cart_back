<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_an_email()
    {
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['password']);
    }

    public function test_it_requires_a_valid_credentials()
    {
        $user = factory(User::class)->create();
        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'nope'
        ])
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_returns_token_if_credentials_do_match()
    {
        $user = factory(User::class)->create([
            'password' => 'cats'
        ]);
        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'cats'
        ])
            ->assertJsonStructure([
                'meta' => [
                    'token'
                ]
            ]);
    }

    public function test_it_returns_user_if_credentials_do_match()
    {
        $user = factory(User::class)->create([
            'password' => 'cats'
        ]);
        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'cats'
        ])
            ->assertJsonFragment([
                'email' => $user->email
            ]);
    }
}
