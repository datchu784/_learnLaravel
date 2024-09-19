<?php

namespace App\Http\Controllers;

use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;



abstract class BaseApiController extends Controller
{
    protected  $service;

    public function index(): JsonResponse
    {
        $items = $this->service->paginate();
        return response()->json($items);
    }

    public function show($id): JsonResponse
    {
        $item = $this->service->getById($id);
        return response()->json($item);
    }

    public function storeBase(Request $request): JsonResponse
    {
        $data = $request->all();
        $item = $this->service->create($data);
        return response()->json($item, 201);
    }

    public function updateBase(Request $request, $id): JsonResponse
    {
        $data = $request->all();
        $item = $this->service->update($id, $data);
        return response()->json($item, 200);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->service->delete($id);
        return response()->json(['message' => 'Item deleted successfully'],204);
    }

}
