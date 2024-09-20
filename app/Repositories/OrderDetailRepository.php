<?php

namespace App\Repositories;

use App\Models\OrderDetail;
use App\Repositories\Interfaces\IOrderDetailRepository;


class OrderDetailRepository extends BaseRepository implements IOrderDetailRepository
{
    public function __construct(OrderDetail $model)
    {
        $this->model = $model;
    }
}
