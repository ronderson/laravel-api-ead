<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreView;
use App\Http\Resources\LessonResource;
use App\Repositories\LessonRepository;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    protected $lessonRepository;

    public function __construct(LessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }
    public function index($moduleId)
    {
        return LessonResource::collection($this->lessonRepository->getLessonsByModuleId($moduleId));
    }
    public function show($lessonId)
    {
        return new LessonResource($this->lessonRepository->getLesson($lessonId));
    }

    public function viewed(StoreView $request)
    {
        $this->lessonRepository->markLessonViewed($request->lesson);
        return response()->json(['success' => true]);
    }
}
