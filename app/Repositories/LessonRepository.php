<?php

namespace App\Repositories;


use App\Models\Lesson;
use App\Repositories\Traits\RepositoryTrait;

class LessonRepository
{
    use RepositoryTrait;
    protected $entity;

    public function __construct(Lesson $model)
    {
        $this->entity = $model;
    }

    public function getLessonsByModuleId(string $moduleId)
    {
        return $this->entity
            ->with('supports.replies')
            ->where('module_id', $moduleId)
            ->get();
    }
    public function getLesson(string $identify)
    {
        return $this->entity->findOrFail($identify);
    }

    public function markLessonViewed(string $lesson_id)
    {
        $user = $this->getUserAuth();
        $view = $user->views()->where('lesson_id', $lesson_id)->first();
        if ($view) {
            return  $view->update([
                'qty' => $view->qty + 1
            ]);
        }

        return  $this->getUserAuth()->views()->create([
            'lesson_id' => $lesson_id
        ]);
    }
}
