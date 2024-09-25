<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Services\PaymentService;


class PaymentController extends BaseApiController
{

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    public function store(PaymentRequest $request)
    {
        return $this->storeBase($request);
    }

}
