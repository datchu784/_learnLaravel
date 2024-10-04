<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\IProductRepository;

class ProductRepository extends BaseRepository implements IProductRepository
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function search($keyword)
    {
        return $this->model->where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->get();
    }
    public function updateQuantity($id, int $quantity)
    {
        $product = $this->getById($id);
        $product->quantity += $quantity;
        return $product->save() ? $product : false;
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }




}
