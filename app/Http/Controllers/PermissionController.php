<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;

class PermissionController extends BaseApiController
{
    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }
    public function store(PermissionRequest $request): JsonResponse
    {
        return $this->storeBase($request);
    }

    public function update(PermissionRequest $request, int $id): JsonResponse
    {
        return $this->updateBase($request, $id);
    }
}
