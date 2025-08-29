<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplySupport;
use App\Http\Resources\ReplySupportResource;
use Illuminate\Http\Request;

class ReplySupportController extends Controller
{
    public function createReply(StoreReplySupport $request, string $supportId)
    {
        $reply =  $this->supportRepository->createReplyToSupportId($supportId, $request->validated());
        return new ReplySupportResource($reply);
    }
}
