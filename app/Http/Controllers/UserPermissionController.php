<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPermissionRequest;
use App\Services\UserPermissionService;
use Illuminate\Http\JsonResponse;

class UserPermissionController extends BaseApiController
{
    public function __construct(UserPermissionService $service)
    {
        $this->service = $service;
    }
    public function store(UserPermissionRequest $request): JsonResponse
    {
        return $this->storeBase($request);
    }

    public function update(UserPermissionRequest $request, int $id): JsonResponse
    {
        return $this->updateBase($request, $id);
    }
}
