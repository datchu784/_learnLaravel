<?php

namespace App\Repositories;


use App\Models\ProductAttribute;
use App\Repositories\Interfaces\IProductAttributeRepository;


class ProductAttributeRepository extends BaseRepository implements IProductAttributeRepository
{
    public function __construct(ProductAttribute $model)
    {
        $this->model = $model;
    }
}
