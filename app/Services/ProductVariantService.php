<?php

namespace App\Services;

use App\Repositories\Interfaces\IProductVariantRepository;

class ProductVariantService extends BaseService
{
    public function __construct(IProductVariantRepository $repository)
    {
        $this->repository = $repository;
    }

    public function filter(array $data)
    {
        $filter = $this->repository->filter($data);
        return $filter;
    }
}
