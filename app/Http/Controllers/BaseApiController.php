<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;



abstract class BaseApiController extends Controller
{
    protected  $service;

    public function index(): JsonResponse
    {
        $items = auth()->check()
            ? $this->service->getAllForCurrentUser()
            : $this->service->paginate();
        return response()->json($items);
    }

    public function show($id): JsonResponse
    {
        $item =  auth()->check()
            ? $this->service->getByIdForCurrentUser($id)
            : $this->service->getById($id);
        return response()->json($item);
    }

    public function storeBase(Request $request): JsonResponse
    {
        $data = $request->all();
        $item =  auth()->check()
            ? $this->service->createForCurrentUser($data)
            : $this->service->create($data);
        return response()->json($item, 201);
    }

    public function updateBase(Request $request, $id): JsonResponse
    {
        $data = $request->all();
        $item =  auth()->check()
            ? $this->service->updateForCurrentUser($id, $data)
            : $this->service->update($id, $data);
        return response()->json($item, 200);
    }

    public function destroy($id): JsonResponse
    {
        auth()->check()
            ? $this->service->deleteForCurrentUser($id)
            : $this->service->delete($id);
        return response()->json(['message' => 'Item deleted successfully'], 204);
    }

}
