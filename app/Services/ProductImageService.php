<?php

namespace App\Services;

use App\Repositories\Interfaces\IProductImageRepository;

class ProductImageService extends BaseService
{


    public function __construct(IProductImageRepository $repository)
    {
        $this->repository = $repository;
    }
}
