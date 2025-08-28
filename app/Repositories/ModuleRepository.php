<?php

namespace App\Repositories;

use App\Models\Module;

class ModuleRepository
{
    protected $entity;

    public function __construct(Module $entity)
    {
        $this->entity = $entity;
    }

    public function getModulesByCourseId(String $courseId)
    {
        return $this->entity->where('course_id', $courseId)->get();
    }
}
