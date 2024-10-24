<?php

namespace App\Http\Controllers;


use App\Http\Requests\AttributeRequest;
use Illuminate\Http\Request;


use App\Services\AttributeService;
use Illuminate\Http\JsonResponse;

class AttributeController extends BaseApiController
{
    public function __construct(AttributeService $service)
    {
        $this->service = $service;
    }
    public function store(AttributeRequest $request): JsonResponse
    {
        return $this->storeBase($request);
    }

    public function update(AttributeRequest $request, int $id): JsonResponse
    {
        return $this->updateBase($request, $id);
    }

    public function index()
    {
        $items = $this->service->getAll();
        return response()->json($items);
    }
}
