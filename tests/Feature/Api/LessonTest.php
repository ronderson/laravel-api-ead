<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use UtilsTrait;
    /**
     * A basic feature test example.
     */
    public function test_unauthenticated(): void
    {
        $response = $this->getJson('/modules/fake_id/lessons');

        $response->assertStatus(401);
    }

    public function test_get_lessons_of_module_not_found(): void
    {
        $token = $this->createTokenUser();
        $response = $this->getJson('/modules/fake_id/lessons', $token);

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


    public function test_get_lessons_of_module_total(): void
    {
        $module = Module::factory()->create();
        $lessons = Lesson::factory()->count(10)
            ->create(['module_id' => $module->id]);
        $token = $this->createTokenUser();

        $response = $this->getJson("/modules/{$module->id}/lessons", $token);

        $response->assertStatus(200)
            ->assertJsonCount(count($lessons), 'data');
    }

    public function test_get_one_lesson_unauthenticated(): void
    {
        $lesson = Lesson::factory()->create();

        $response = $this->getJson("/lessons/{$lesson->id}");

        $response->assertStatus(401);
    }
    public function test_get_one_lesson_not_found(): void
    {
        $token = $this->createTokenUser();

        $response = $this->getJson("/lessons/fake_id", $token);

        $response->assertStatus(404);
    }

    public function test_get_one_lesson(): void
    {
        $lesson = Lesson::factory()->create();
        $token = $this->createTokenUser();

        $response = $this->getJson("/lessons/{$lesson->id}", $token);

        $response->assertStatus(200);
    }
}
