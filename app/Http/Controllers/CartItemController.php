<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemEditRequest;
use App\Http\Requests\CartItemRequest;
use App\Services\CartItemService;


class CartItemController extends BaseApiController
{
    public function __construct(CartItemService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
       $cartItems =  $this->indexAuthenticated();

        return response()->json($cartItems);
    }


    public function store(CartItemRequest $request)
    {
        //$request->merge(['cart_id' => 1]); thêm dữ liệu cho $request
        return $this->storeAuthenticated($request);
    }

    public function update(CartItemEditRequest $request, int $id)
    {
        return $this->updateBase($request, $id);
    }

    public function destroy($id)
    {

        $item = $this->service->destroyAuthenticated($id);
        return response()->json(['message' => 'Item deleted successfully'], 204);
    }



}
