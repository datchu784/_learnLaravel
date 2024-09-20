<?php

namespace App\Http\Controllers;


use App\Services\CartItemService;


class CartItemItemController extends Controller
{
    private $service;

    public function __construct(CartItemService $service)
    {
        $this->service = $service;
    }
    public function get()
    {
        $userId = auth()->id();
        $cart = $this->service->getCartItem($userId);
        return response()->json($cart, 200);
    }
}
