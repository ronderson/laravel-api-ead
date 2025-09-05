<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Api\UtilsTrait;
use Tests\TestCase;


class AuthTest extends TestCase
{
    use UtilsTrait;
    /**
     * A basic feature test example.
     */
    public function test_fail_auth(): void
    {
        $response = $this->postJson('/auth', []);

        $response->assertStatus(422);
    }
    public function test_auth(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/auth', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'test'
        ]);

        $response->assertStatus(200);
    }

    public function test_fail_logout(): void
    {
        $response = $this->postJson('/logout', []);

        $response->assertStatus(401);
    }
    public function test_logout(): void
    {
        $response = $this->postJson(
            '/logout',
            [],
            $this->createTokenUser()
        );

        $response->assertStatus(200);
    }

    public function test_fail_get_me(): void
    {
        $response = $this->getJson('/me', []);

        $response->assertStatus(401);
    }

    public function test_get_me(): void
    {
        $response = $this->getJson(
            '/me',
            $this->createTokenUser()
        );

        $response->assertStatus(200);
    }
}
