<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDetailRequest;
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

        $paymentData = $request->input('payment');
        $orderDetailsData = $request->input('order_details');
        $item = $this->service->createPayment($paymentData, $orderDetailsData);
        return response()->json($item, 201);

    }

}
