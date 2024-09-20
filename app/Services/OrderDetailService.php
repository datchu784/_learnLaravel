<?php

namespace App\Services;

use App\Repositories\Interfaces\IOrderDetailRepository;


class OrderDetailService extends BaseService
{


    public function __construct(IOrderDetailRepository $repository)
    {
        $this->repository = $repository;
    }
}
