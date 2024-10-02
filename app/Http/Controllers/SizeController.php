<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Services\SizeService;
use Illuminate\Http\JsonResponse;

class SizeController extends BaseApiController
{
    public function __construct(SizeService $service)
    {
        $this->service = $service;
    }
    public function store(Request $request): JsonResponse
    {
        return $this->storeBase($request);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        return $this->updateBase($request, $id);
    }
}
