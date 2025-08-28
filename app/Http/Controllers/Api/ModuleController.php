<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModuleResource;
use App\Repositories\ModuleRepository;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    protected $repository;

    public function __construct(ModuleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index($courseId)
    {
        return ModuleResource::collection($this->repository->getModulesByCourseId($courseId));
    }
    public function show($id)
    {
        //return new CourseResource($this->repository->getCourse($id));
    }
}
