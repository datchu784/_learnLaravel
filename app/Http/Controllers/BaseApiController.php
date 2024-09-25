<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseApiController extends Controller
{
    protected  $service;

    public function index()
    {
        $items = $this->service->paginate();
        return response()->json($items);
    }

    public function show($id)
    {
        $item = $this->service->getById($id);

        return response()->json($item);
    }

    public function storeBase(Request $request)
    {
        $data = $request->all();

        $item = $this->service->create($data);
        return response()->json($item, 201);
    }

    public function updateBase(Request $request, $id)
    {
        $data = $request->all();

        $item = $this->service->update($id, $data);
        return response()->json($item, 200);
    }

    public function destroy($id)
    {

        $item = $this->service->delete($id);
        return response()->json(['message' => 'Item deleted successfully'], 204);
    }

    public function indexAuthenticated()
    {
        $this->middleware('auth');
        $items = $this->service->getAllForCurrentUser();
        return response()->json($items);
    }

    public function showAuthenticated($id)
    {
        $this->middleware('auth');
        $item = $this->service->getByIdForCurrentUser($id);
        return response()->json($item);
    }

    public function storeAuthenticated(Request $request)
    {
        $this->middleware('auth');
        $data = $request->all();
        $item = $this->service->createForCurrentUser($data);
        return response()->json($item, 201);
    }

    public function updateAuthenticated(Request $request, $id)
    {
        $this->middleware('auth');
        $data = $request->all();
        $item = $this->service->updateForCurrentUser($id, $data);
        return response()->json($item, 200);
    }

    public function destroyAuthenticated($id)
    {
        $this->middleware('auth');
        $result = $this->service->deleteForCurrentUser($id);
        return response()->json(['message' => 'Item deleted successfully'], 204);
    }

}
