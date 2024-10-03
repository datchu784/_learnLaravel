<?php

namespace App\Http\Controllers;


use App\Http\Requests\AttributeValueRequest;
use Illuminate\Http\Request;


use App\Services\AttributeValueService;
use Illuminate\Http\JsonResponse;

class AttributeValueController extends BaseApiController
{
    public function __construct(AttributeValueService $service)
    {
        $this->service = $service;
    }
    public function store(AttributeValueRequest $request): JsonResponse
    {
        return $this->storeBase($request);
    }

    public function update(AttributeValueRequest $request, int $id): JsonResponse
    {
        return $this->updateBase($request, $id);
    }
}
