<?php

namespace App\Services;

use App\Repositories\Interfaces\IProductTypeRepository;


class ProductTypeService extends BaseService
{
    //protected $productTypeRepository;

    public function __construct(IProductTypeRepository $repository)
    {
        $this->repository = $repository;
    }
}

