<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Services\AttributeService;
use Illuminate\Http\JsonResponse;

class AttributeController extends BaseApiController
{
    public function __construct(AttributeService $service)
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
