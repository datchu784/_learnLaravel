<?php

namespace App\Repositories;

use App\Models\ProductType;
use App\Repositories\Interfaces\IProductTypeRepository;


class ProductTypeRepository extends BaseRepository implements IProductTypeRepository
{
    public function __construct(ProductType $model)
    {
        $this->model = $model;
    }
    public function updateQuantity($id, $quantity)
    {
        $productType = $this->getById($id);
        $productType->quantity += $quantity;
        return $productType->save() ? $productType : false;
    }
}
