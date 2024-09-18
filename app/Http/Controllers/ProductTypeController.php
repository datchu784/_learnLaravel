<?php

namespace App\Http\Controllers;

use App\Services\ProductTypeService;
use Illuminate\Http\Request;
use App\Http\Controllers\JsonResponse;
use App\Http\Requests\StorePostRequest;
use App\Models\ProductType;
use Psr\Http\Message\ResponseInterface;

class ProductTypeController extends BaseApiController
{
    protected $service;

    public function __construct(ProductTypeService $service)
    {
        $this->$service = $service;
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
