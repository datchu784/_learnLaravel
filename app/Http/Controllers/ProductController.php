<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProductRequest;
class ProductController extends BaseApiController
{
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function store(ProductRequest $request): JsonResponse
    {
        return $this-> storeBase($request);
    }

    public function update(ProductRequest $request, int $id): JsonResponse
    {
        return $this->updateBase($request, $id);
    }

    public function search(Request $request): JsonResponse
    {
        $keyword = $request->keyword;
        $products = $this->service->searchProducts($keyword);
        return response()->json($products);
    }


    public function updateQuantityProduct(Request $request)
    {
        $product = $this->service->updateQuantityProduct($request->id, $request->quantity);
        return response()->json(null, 200);
    }
}



