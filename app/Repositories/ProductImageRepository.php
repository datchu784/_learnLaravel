<?php

namespace App\Repositories;


use App\Models\ProductImage;
use App\Repositories\Interfaces\IProductImageRepository;


class ProductImageRepository extends BaseRepository implements IProductImageRepository
{
    public function __construct(ProductImage $model)
    {
        $this->model = $model;
    }
}
