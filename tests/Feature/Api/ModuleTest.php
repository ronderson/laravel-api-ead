<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModuleTest extends TestCase
{
    use UtilsTrait;
    /**
     * A basic feature test example.
     */
    public function test_unauthenticated(): void
    {
        $response = $this->getJson('/courses/fake_id/modules');

        $response->assertStatus(401);
    }

    public function test_get_modules_course_not_found(): void
    {
        $token = $this->createTokenUser();
        $response = $this->getJson('/courses/fake_id/modules', $token);

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function test_get_modules_course(): void
    {
        $course = Course::factory()->create();
        $token = $this->createTokenUser();

        $response = $this->getJson("/courses/{$course->id}/modules", $token);

        $response->assertStatus(200);
    }

    public function test_get_modules_course_all(): void
    {
        $course = Course::factory()->create();
        $modules = Module::factory()->count(10)
            ->create(['course_id' => $course->id]);
        $token = $this->createTokenUser();

        $response = $this->getJson("/courses/{$course->id}/modules", $token);

        $response->assertStatus(200)
            ->assertJsonCount(count($modules), 'data');
    }
}
