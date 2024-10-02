<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductVariantRequest;

use App\Services\ProductVariantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductVariantController extends BaseApiController
{
    public function __construct(ProductVariantService $service)
    {
        $this->service = $service;
    }
    public function store(ProductVariantRequest  $request): JsonResponse
    {
        return $this->storeBase($request);
    }

    public function update(ProductVariantRequest  $request, int $id): JsonResponse
    {
        return $this->updateBase($request, $id);
    }

    public function filter(Request $request)
    {
        $data = $request->all();
        $productFilter =  $this->service->filter($data);
        return response()->json($productFilter,200);

    }
}
