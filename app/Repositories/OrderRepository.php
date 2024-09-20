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
}
