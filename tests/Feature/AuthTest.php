<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $password = 'secret';
        $email = 'user@email.com';

        $this->userData = [
            'email' => $email,
            'password' => $password,
        ];

        $this->seed(UserSeeder::class);
    }

    public function test_user_login(): void
    {
        $this->post('/api/auth/login', $this->userData)
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }

    public function test_fail_user_login(): void
    {
        $this->userData['password'] = 'fail';
        $this->post('/api/auth/login', $this->userData)
            ->assertStatus(401);
    }

    public function test_get_user_data(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/api/auth/me')
            ->assertStatus(200);
    }
}
