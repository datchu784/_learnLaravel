<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolePostRequest;
use App\Http\Requests\RolePutRequest;
use Illuminate\Http\Request;


use App\Services\RoleService;
use Illuminate\Http\JsonResponse;

class RoleController extends BaseApiController
{
    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }
    public function store(RolePostRequest $request): JsonResponse
    {
        return $this->storeBase($request);
    }

    public function update(RolePostRequest $request, int $id ): JsonResponse
    {
        return $this->updateBase($request, $id);
    }



}
