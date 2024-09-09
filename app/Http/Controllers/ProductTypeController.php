<?php

namespace App\Http\Controllers;

use App\Services\ProductTypeService;
use Illuminate\Http\Request;
use App\Http\Controllers\JsonResponse;
use App\Models\ProductType;
use Psr\Http\Message\ResponseInterface;

class ProductTypeController extends Controller
{
    protected $productTypeService;

    public function __construct(ProductTypeService $productTypeService)
    {
        $this->productTypeService = $productTypeService;

    }

    public function index()
    {
        try {
            return response()->json($this->productTypeService->getAllProductTypes());
        } catch (\Throwable $th) {
            return response()->json($th);

        }
    }

    public function show($id)
    {
        return response()->json($this->productTypeService->getProductTypeById($id));
    }

    public function store(Request $request)
    {
        $productType = $this->productTypeService->createProductType($request->all());
        return response()->json($productType,201);
    }

    public function update($id, Request $request)
    {
        $productType= $this->productTypeService->updateProductType($id, $request->all());
        return response()->json($productType,200);
    }

    public function destroy($id)
    {
        $this->productTypeService->deleteProductType($id);
        return response()->json(null,204);
    }

}

