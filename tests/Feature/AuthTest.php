<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /*
     * Tests that any route with auth:api now has authentication protection
     */
    public function test_unauthenticated()
    {
        $this->json('get', 'api/unauthenticated')
            ->assertStatus(401)
            ->assertJsonStructure([
                'message'
            ])
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public function test_invalid_login_attempt()
    {
        $payload = [
            'email' => 'random@random.com',
            'password' => 'testrandom'
        ];
        $this->json('post', 'api/login', $payload)
            ->assertStatus(401)
            ->assertJsonStructure([
                'message'
            ])
            ->assertJson([
                'message' => 'Invalid Credentials'
            ]);
    }

    public function test_login_attempt()
    {
        $user = User::factory()->create(['password' => bcrypt('test123')]);

        $payload = [
            'email' => $user->email,
            'password' => 'test123'
        ];

        $this->json('post', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'token',
                    'token_type',
                    'expires_in'
                ]
            ]);
    }
}
