<?php

namespace App\Http\Controllers;


use App\Services\CartItemService;


class CartItemController extends Controller
{
    private $service;

    public function __construct(CartItemService $service)
    {
        $this->service = $service;
    }
    public function get()
    {
        $cart = $this->service->getCartItem();
        return response()->json($cart, 200);
    }
}
