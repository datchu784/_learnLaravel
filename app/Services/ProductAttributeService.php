<?php

namespace App\Services;

use App\Repositories\Interfaces\IProductAttributeRepository;

class ProductAttributeService extends BaseService
{
    public function __construct(IProductAttributeRepository $repository)
    {
        $this->repository = $repository;
    }
}
