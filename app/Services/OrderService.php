<?php

namespace App\Services;

use App\Repositories\Interfaces\IOrderRepository;


class OrderService extends BaseService
{
    public function __construct(IOrderRepository $repository)
    {
        $this->repository = $repository;
    }


    public function getByIdForCurrentUser($id)
    {
        $userId = $this->getCurrentUserId();
        $orderDetail = $this->repository->joinOrderDetail($id, $userId);
        return $orderDetail;
    }

    public function orderStatus($status)
    {
        $userId = $this->getCurrentUserId();
        $items = $this->repository->orderStatus($userId,$status);

        return $items;
    }
}
