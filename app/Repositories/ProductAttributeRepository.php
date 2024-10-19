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

    public function joinToFilter($sort_by=null, $order = 'asc')
    {
        $query = $this->model
            ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
            ->join('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
            ->join('product_combinations', 'product_attributes.product_combination_id', '=', 'product_combinations.id')
            ->join('products', 'product_combinations.product_id', '=', 'products.id')
            ->leftJoin('product_images as main_image', function ($join) {
                $join->on('main_image.product_combination_id', '=', 'product_combinations.id')
                ->where('main_image.main', 1);
            })
            ->leftJoin('product_images as other_images', function ($join) {
            $join->on('other_images.product_combination_id', '=', 'product_combinations.id')
            ->where('other_images.main', 0);
        })
            ->select(
                'products.name as product_name',
                'attributes.name as attribute_name',
                'attribute_values.value as attribute_value',
                'product_combinations.price as product_price',
                'product_combinations.stock as stock',
                'product_combinations.id as combination_id',
                'main_image.path as main_image',
                'other_images.path as other_image',
                 'products.id as product_id'
            );

            if($sort_by)
            {
               $query->orderBy($sort_by, $order);
            }
        $products = $query->get();



        // foreach ($products as $product) {
        //     if (!$product->productImages_path) {
        //         $product->productImages_path = '/storage/images/default.png';
        //     }
        // }

        return $this->map($products);
    }

    public function map($products)
    {
        return $products
        ->groupBy('combination_id')
        ->map(function ($group) {
            return [
                'producombination_id'=> $group->first()->combination_id,
                'product_name' => $group->first()->product_name,
                'attributes' => $group->pluck('attribute_value', 'attribute_name')->toArray(),
                'product_price' => $group->first()->product_price,
                'stock' => $group->first()->stock,
                'main_image' => $group->first()->main_image ?? '/storage/images/default.png',
                'other_images' => $group->pluck('other_image')->filter()->unique()->values(),
                'product_id' => $group->first()->product_id
            ];
        })
        // nếu dùng all() thì sẽ trả về array, mà chỉ muốn trả về colection nên không dùng all()
        ->values();
    }



    public function getById($id)
    {
        return $this->model->find($id);
    }

}
