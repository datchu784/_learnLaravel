<?php

namespace App\Http\Controllers;

use App\Services\OrderDetailService;


class OrderDetailController extends BaseApiController
{

    public function __construct(OrderDetailService $service)
    {
        $this->service = $service;
    }

    
}
