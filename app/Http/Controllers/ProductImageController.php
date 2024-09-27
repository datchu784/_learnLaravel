<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImageEditRequest;
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
        $item= $this->service->createImage($request);
        return response()->json($item, 201);
    }

    public function updateImage(ProductImageEditRequest $request,int $id): JsonResponse
    {
        $item = $this->service->updateImage($id,$request);
        return response()->json($item, 201);
    }
}
