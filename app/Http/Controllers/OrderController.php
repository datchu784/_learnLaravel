<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

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

    public function orderStatus(Request $request)
    {
        $status = $request->keyword;
        $items = $this->service->orderStatus($status);

        return response()->json($items);
    }

    public function update(Request $request, $id)
    {


        $item = $this->updateBase( $request,$id);
        return response()->json($item, 200);
    }


}
