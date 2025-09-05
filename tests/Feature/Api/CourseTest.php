<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use UtilsTrait;
    /**
     * A basic feature test example.
     */
    public function test_unauthenticated(): void
    {
        $response = $this->getJson('/courses');

        $response->assertStatus(401);
    }
    public function test_get_all_courses(): void
    {
        $token = $this->createTokenUser();
        $response = $this->getJson('/courses', $token);

        $response->assertStatus(200);
    }

    public function test_get_all_courses_total(): void
    {
        $courses = Course::factory()->count(10)->create();
        $token = $this->createTokenUser();
        $response = $this->getJson('/courses', $token);

        $response->assertStatus(200)
            ->assertJsonCount(count($courses), 'data');
    }

    public function test_get_one_course_unauthenticated(): void
    {
        $response = $this->getJson("/courses/fake_id");

        $response->assertStatus(401);
    }
    public function test_get_one_course_not_found(): void
    {
        $courses = Course::factory()->count(10)->create();
        $token = $this->createTokenUser();
        $response = $this->getJson("/courses/fake_id", $token);

        $response->assertStatus(404);
    }

    public function test_get_one_course_by_id(): void
    {
        $course = Course::factory()->create();
        $token = $this->createTokenUser();
        $response = $this->getJson("/courses/{$course->id}", $token);

        $response->assertStatus(200);
    }
}
