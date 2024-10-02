<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Services\ColorService;
use Illuminate\Http\JsonResponse;

class ColorController extends BaseApiController
{
    public function __construct(ColorService $service)
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
