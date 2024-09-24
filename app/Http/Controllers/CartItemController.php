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

    public function store(CartItemRequest $request)
    {
        return $this->storeBase($request);
    }


}
