<?php

namespace App\Services;

use App\Repositories\Interfaces\IOrderRepository;


class OrderService extends BaseService
{


    public function __construct(IOrderRepository $repository)
    {
        $this->repository = $repository;
    }
}
