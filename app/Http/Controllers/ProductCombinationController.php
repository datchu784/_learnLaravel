<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCombinationPostRequest;
use App\Http\Requests\ProductCombinationPutRequest;

use App\Services\ProductCombinationService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductCombinationController extends BaseApiController
{
    public function __construct(ProductCombinationService $service)
    {
        $this->service = $service;
    }
    public function store(ProductCombinationPostRequest $request): JsonResponse
    {
        return $this->storeBase($request);
    }

    public function update(ProductCombinationPutRequest $request, int $id): JsonResponse
    {
        return $this->updateBase($request, $id);
    }

    public function updateQuantityProduct(Request $request)
    {
        $product = $this->service->updateQuantityProduct($request->id, $request->quantity);
        return response()->json(null, 200);
    }
}
