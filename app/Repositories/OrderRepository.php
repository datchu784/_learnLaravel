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
        ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
        ->select('orders.*')
        ->first();

        if ($order) {
           
            $order->load('orderDetails.product');
            return $order;
        } else {
            return null;
        }

    }


}
