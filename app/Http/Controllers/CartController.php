<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartPostRequest;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    private $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $userId = auth()->id();
        $cart = $this->service->getCart($userId);
        return response()->json($cart, 200);
    }


}
