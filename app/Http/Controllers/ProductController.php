<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProductRequest;

use App\Models\ProductVariant;

class ProductController extends BaseApiController
{
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->service->uploadImage($request);
        if ($request->hasFile('file'))
        {
            $request->merge(['url' => $product]);
        }

        return $this->storeBase($request);
    }

    public function update(ProductRequest $request, $id): JsonResponse
    {
        return $this->updateBase($request,$id);
    }


    public function updateImage(Request $request, int $id): JsonResponse
    {
        $product = $this->service->updateImage($id, $request);

        return response()->json($product);
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

    public function filter(Request $data, $id)
    {
        return response()->json($this->service->filter($data, $id));

    }
}



