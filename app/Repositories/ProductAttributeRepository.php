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

    public function joinToFilter()
    {
         $joins = $this->model
            ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
            ->join('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
            ->join('product_combinations', 'product_attributes.product_combination_id', '=', 'product_combinations.id')
            ->join('products', 'product_combinations.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name',
                'attributes.name as attribute_name',
                'attribute_values.value as attribute_value',
                'product_combinations.price as product_price',
                'product_combinations.stock as stock',
                'product_combinations.id as combination_id'
            )
            ->get();

            return $this->map($joins);
    }

    public function map($joins)
    {
        return $joins
        ->groupBy('combination_id')
        ->map(function ($group) {
            return [
                'product_name' => $group->first()->product_name,
                'attributes' => $group->pluck('attribute_value', 'attribute_name')->toArray(),
                'product_price' => $group->first()->product_price,
                'stock' => $group->first()->stock
            ];
        })
        // nếu dùng all() thì sẽ trả về array, mà chỉ muốn trả về colection nên không dùng all()
        ->values();


    }

}
