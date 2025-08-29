<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplySupport;
use App\Http\Requests\StoreSupport;
use App\Http\Resources\ReplySupportResource;
use App\Http\Resources\SupportResource;
use App\Repositories\SupportRepository;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    protected $supportRepository;

    public function __construct(SupportRepository $supportRepository)
    {
        $this->supportRepository = $supportRepository;
    }

    public function index(Request $request)
    {
        $supports = $this->supportRepository->getSupports($request->all());
        return SupportResource::collection($supports);
    }

    public function store(StoreSupport $request)
    {
        $support =  $this->supportRepository->createSupport($request->validated());
        return new SupportResource($support);
    }

    public function mySupports(Request $request)
    {
        $supports = $this->supportRepository->getMySupports($request->all());
        return SupportResource::collection($supports);
    }

}
