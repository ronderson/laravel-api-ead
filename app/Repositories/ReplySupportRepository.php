<?php

namespace App\Repositories;

use App\Models\ReplySupport;
use App\Repositories\Traits\RepositoryTrait;

class ReplySupportRepository
{
    use RepositoryTrait;
    protected $entity;

    public function __construct(ReplySupport $model)
    {
        $this->entity = $model;
    }

    public function getSupports(array $filters = [])
    {
        return $this->getUserAuth()
            ->supports()
            ->where(function ($query) use ($filters) {
                if (isset($filters['lesson'])) {
                    $query->where('lesson_id', $filters['lesson']);
                }
                if (isset($filters['status'])) {
                    $query->where('status', $filters['status']);
                }
                if (isset($filters['filter'])) {
                    $filter = $filters['filter'];
                    $query->where('description', 'like', "%{$filter}%");
                }
            })
            ->orderBy('updated_at')
            ->get();
    }



    public function createReplyToSupport(array $data)
    {
        return $this->entity
            ->replies()
            ->create([
                'support_id' => $data['support'],
                'description' => $data['description'],
                'user_id' => $this->getUserAuth()->id,
            ]);
    }
}
