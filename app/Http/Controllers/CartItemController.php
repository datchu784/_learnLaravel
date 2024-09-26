<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Services\CartItemService;


class CartItemController extends BaseApiController
{
    public function __construct(CartItemService $service)
    {
        $this->service = $service;
    }
    // public function get()
    // {
    //     $cart = $this->service->getCartItem();
    //     return response()->json($cart, 200);
    // }
    public function index()
    {
       $cartItems =  $this->indexAuthenticated();

        return response()->json($cartItems);
    }

    public function show($id)
    {
        $cartItem =  $this->showAuthenticated($id);

        return response()->json($cartItem);
    }

    public function store(CartItemRequest $request)
    {
        //$request->merge(['cart_id' => 1]); thêm dữ liệu cho $request
        return $this->storeAuthenticated($request);
    }

    public function update(CartItemRequest $request, int $id)
    {
        return $this->updateBase($request, $id);
    }


}
