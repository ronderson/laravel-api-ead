<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplySupport;
use App\Http\Resources\ReplySupportResource;
use App\Repositories\ReplySupportRepository;
use Illuminate\Http\Request;

class ReplySupportController extends Controller
{
    protected $supportRepository;
    public function __construct(ReplySupportRepository $supportRepository)
    {
        $this->supportRepository = $supportRepository;
    }
    public function createReply(StoreReplySupport $request)
    {
        $reply =  $this->supportRepository->createReplyToSupport($request->validated());
        return new ReplySupportResource($reply);
    }
}
