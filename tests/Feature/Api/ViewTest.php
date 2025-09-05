<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    use UtilsTrait;

    public function test_make_viewed_unauthenticated(): void
    {
        $response = $this->postJson('/lessons/viewed');

        $response->assertStatus(401);
    }
    public function test_make_viewed_error_validator(): void
    {
        $payload = [];
        $token = $this->createTokenUser();
        $response = $this->postJson('/lessons/viewed', $payload, $token);

        $response->assertStatus(422);
    }

    public function test_make_viewed_invalid_lesson(): void
    {
        $payload = ['lesson' => 'fake_id'];
        $token = $this->createTokenUser();
        $response = $this->postJson('/lessons/viewed', $payload, $token);

        $response->assertStatus(422);
    }

    public function test_make_viewed(): void
    {
        $lesson = Lesson::factory()->create();
        $payload = ['lesson' => $lesson->id];

        $token = $this->createTokenUser();
        $response = $this->postJson('/lessons/viewed', $payload, $token);

        $response->assertStatus(200);
    }
}
