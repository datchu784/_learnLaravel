<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;


class OrderController extends BaseApiController
{

    public function __construct(OrderService $service)
    {
        $this->service = $service;
        //$this->authorizeResource(Order::class, 'id');
    }

    public function show($id)
    {
        $this->authorize('view', [Order::class, $id]);
        $item = $this->showAuthenticated($id);

        return response()->json($item);
    }


}
