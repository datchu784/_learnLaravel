<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Interfaces\IPaymentRepository;


class PaymentRepository extends BaseRepository implements IPaymentRepository
{
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }
}
