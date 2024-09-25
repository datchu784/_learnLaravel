<?php

namespace App\Services;

use App\Repositories\Interfaces\IOrderRepository;


class OrderService extends BaseService
{
    public function __construct(IOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function joinOrderDetail()
    {
        $order = $this->repository->model
        ->leftJoin('orders', 'order_details.order_id','=', 'orders.id')
        ->select('orders.*')
        ->get();

        $order->orderDetails;
    }
    
}
