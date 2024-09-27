<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImageRequest;
use App\Services\ProductImageService;
use Illuminate\Http\JsonResponse;

class ProductImageController extends BaseApiController
{
    public function __construct(ProductImageService $service)
    {
        $this->service = $service;
    }
    public function store(ProductImageRequest $request): JsonResponse
    {
        return $this->storeBase($request);
    }

    public function update(ProductImageRequest $request, int $id): JsonResponse
    {
        return $this->updateBase($request, $id);
    }
}
