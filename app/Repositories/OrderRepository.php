<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\IOrderRepository;


class OrderRepository extends BaseRepository implements IOrderRepository
{
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function joinOrderDetail($id, $userId)
    {
        $order = $this->model
            ->where('user_id', $userId)
            ->where('orders.id', $id)
            ->leftJoin('order_details', 'order_details.order_id', '=', 'orders.id')
            ->select('orders.*')
            ->first();
        if ($order) {
            $order->orderDetails;
        }
        return $order;
    }

   
}
