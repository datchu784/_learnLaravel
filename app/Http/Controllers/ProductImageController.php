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

    public function store(ProductImageRequest $request)
    {
        // $item= $this->service->createImage($request);
        // return response()->json($item, 201);
        return (string) $request->session()->token();
    }

    public function updateImage(ProductImageEditRequest $request,int $id): JsonResponse
    {
        $item = $this->service->updateImage($id,$request);
        return response()->json($item, 201);
    }

    public function changeMain($id)
    {
        $item = $this->service->changeMain($id);
        return response()->json($item,200);
    }
}
