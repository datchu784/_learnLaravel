<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImageRequest;
use App\Services\ProductImageService;
use Illuminate\Http\JsonResponse;

class ProductImageController extends Controller
{
    private $service;
    public function __construct(ProductImageService $service)
    {
        $this->service = $service;
    }
    public function store(ProductImageRequest $request): JsonResponse
    {
        $item= $this->service->uploadImage($request);
        return response()->json($item, 201);
    }

    public function update(ProductImageRequest $request, int $id): JsonResponse
    {
        return $this->updateBase($request, $id);
    }
}
