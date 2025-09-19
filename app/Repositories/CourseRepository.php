<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository
{
    protected $entity;

    public function __construct(Course $entity)
    {
        $this->entity = $entity;
    }

    public function getAllCourses()
    {
        return $this->entity->with('modules.lessons.views')->get();
    }
    public function getCourse(string $identify)
    {
        return $this->entity->with('modules.lessons')->findOrFail($identify)->first();
    }
}
