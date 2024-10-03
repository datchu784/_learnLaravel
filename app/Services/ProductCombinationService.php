<?php

namespace App\Services;

use App\Repositories\Interfaces\IProductCombinationRepository;

class ProductCombinationService extends BaseService
{

    public function __construct(IProductCombinationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function paginate($perPage = 4)
    {
        $products = $this->repository->joinImage($perPage);
        return $products;
    }

    public function getById($id)
    {
        return $this->repository->joinImageById($id);
    }
}
