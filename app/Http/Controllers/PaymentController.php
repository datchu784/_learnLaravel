<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;


class PaymentController extends BaseApiController
{

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }
}
