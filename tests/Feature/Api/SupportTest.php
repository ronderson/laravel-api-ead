<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use App\Models\Support;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupportTest extends TestCase
{
    use UtilsTrait;
    public function test_get_my_support_unauthenticated(): void
    {
        $response = $this->getJson('/my-supports');

        $response->assertStatus(401);
    }

    public function test_get_my_support(): void
    {
        $user = $this->createUser();

        Support::factory()->count(50)->create([
            'user_id' => $user->id
        ]);
        Support::factory()->count(50)->create();

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->getJson('/my-supports', [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(50, 'data');
    }
    public function test_get_supports_unauthenticated(): void
    {
        $response = $this->getJson('/supports');
        $response->assertStatus(401);
    }

    public function test_get_supports(): void
    {
        Support::factory()->count(50)->create();

        $response = $this->getJson(
            '/supports',
            $this->createTokenUser()
        );

        $response->assertStatus(200)->assertJsonCount(50, 'data');
    }

    public function test_get_supports_filter_lesson(): void
    {
        $lesson = Lesson::factory()->create();

        Support::factory()->count(50)->create();
        Support::factory()->count(10)->create([
            'lesson_id' => $lesson->id
        ]);
        $playload = ['lesson' => $lesson->id];

        $response = $this->json(
            'GET',
            '/supports',
            $playload,
            $this->createTokenUser()
        );

        $response->assertStatus(200)->assertJsonCount(10, 'data');
    }
    public function test_get_supports_filter_status(): void
    {

        Support::factory()->count(50)->create(
            ['status' => 'A']
        );
        Support::factory()->count(10)->create([
            'status' => 'P'
        ]);
        $playload = ['status' => 'P'];

        $response = $this->json(
            'GET',
            '/supports',
            $playload,
            $this->createTokenUser()
        );

        $response->assertStatus(200)->assertJsonCount(10, 'data');
    }

    public function test_create_support_unauthenticated(): void
    {
        $response = $this->postJson('/supports');

        $response->assertStatus(401);
    }

    public function test_create_support_error_validator(): void
    {
        $response = $this->postJson(
            '/supports',
            [],
            $this->createTokenUser()
        );

        $response->assertStatus(422);
    }

    public function test_create_support(): void
    {
        $user = $this->createUser();

        $token = $user->createToken('test')->plainTextToken;

        $payload = [
            'status' => 'P',
            'lesson' => Lesson::factory()->create()->id,
            'description' => 'test'
        ];

        $response = $this->postJson('/supports', $payload, [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(201);
    }
}
