<?php

namespace App\Services;

use App\Repositories\Interfaces\IProductTypeRepository;
use Illuminate\Support\Facades\DB;

class ProductTypeService extends BaseService
{
    //protected $productTypeRepository;

    public function __construct(IProductTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getById($id)
    {
        $productType = $this->repository->model
        ->where('product_types.id', $id)
        ->leftJoin('products', 'product_types.id', '=', 'products.product_type_id')
        ->select('product_types.id', 'product_types.name')
        ->first();

        if ($productType) {
            $productType->products;
            return $productType;
        } else {
            return null;
        }

    }


}

