<?php

namespace App\Http\Controllers;

use App\Services\ProductTypeService;
use Illuminate\Http\Request;

use App\Http\Requests\StorePostRequest;


class ProductTypeController extends BaseApiController
{
    //protected $service;

    public function __construct(ProductTypeService $service)
    {
        $this->service = $service;
    }


    public function store(StorePostRequest $request)
    {
        return $this->storeBase($request);

    }

    public function update(Request $request, $id)
    {
        return $this->updateBase($request, $id);

    }

}
