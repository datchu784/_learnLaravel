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

    public function joinImage($perPage)
    {
        return $this->model
        ->leftJoin('product_images',function($join){
            $join->on('product_images.product_id', '=', 'products.id')->where('product_images.main',1);
        })->select('products.*', 'product_images.path as productImages_path')->paginate($perPage);

    }
}
