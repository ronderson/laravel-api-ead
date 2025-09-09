<?php

namespace Tests\Feature\Api;

use App\Models\Support;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReplySupportTest extends TestCase
{
    use UtilsTrait;
    #php artisan test --filter=test_create_reply_support_unauthenticated
    public function test_create_reply_support_unauthenticated(): void
    {
        $response = $this->postJson('/replies');

        $response->assertStatus(401);
    }

    public function test_create_reply_support_error_validator(): void
    {
        $response = $this->postJson('/replies', [], $this->createTokenUser());

        $response->assertStatus(422);
    }

    public function test_create_reply_support(): void
    {
        $support = Support::factory()->create();

        $payload = [
            'support' => $support->id,
            'description' => 'test description reply support',
        ];

        $response = $this->postJson('/replies', $payload, $this->createTokenUser());

        $response->assertStatus(201);
    }
}
