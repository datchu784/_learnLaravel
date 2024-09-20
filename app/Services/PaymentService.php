<?php

namespace App\Services;

use App\Repositories\Interfaces\IPaymentRepository;


class PaymentService extends BaseService
{


    public function __construct(IPaymentRepository $repository)
    {
        $this->repository = $repository;
    }
}
