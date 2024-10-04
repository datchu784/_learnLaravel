<?php

namespace App\Repositories;


use App\Models\ProductCombination;
use App\Repositories\Interfaces\IProductCombinationRepository;


class ProductCombinationRepository extends BaseRepository implements IProductCombinationRepository
{
    public function __construct(ProductCombination $model)
    {
        $this->model = $model;
    }

    public function joinImage($perPage)
    {
        $products = $this->model
            ->leftJoin('product_images', function ($join) {
                $join->on('product_images.product_combination_id', '=', 'product_combinations.id')->where('product_images.main', 1);
            })
            ->join('product_attributes', 'product_attributes.product_combination_id', '=', 'product_combinations.id')
            ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
            ->join('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
            ->join('products', 'product_combinations.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name',
                'products.description as product_description',
                'attributes.name as attribute_name',
                'attribute_values.value as attribute_value',
                'product_combinations.price as product_price',
                'product_combinations.stock as stock',
                'product_combinations.id as combination_id',
                'product_images.path as productImages_path'
            )
            ->get();

        foreach ($products as $product) {
            if (!$product->productImages_path) {
                $product->productImages_path = '/storage/images/default.png';
            }
        }
        return $this->map($products);
    }

    public function map($joins)
    {
        return $joins
            ->groupBy('combination_id')
            ->map(function ($group) {
                return ["product_combination_id: ".$group->first()->combination_id =>  [
                    'product_name' => $group->first()->product_name,
                    'product_description' => $group->first()->product_description,
                    'attributes' => $group->pluck('attribute_value', 'attribute_name')->toArray(),
                    'product_price' => $group->first()->product_price,
                    'stock' => $group->first()->stock,
                    'productImages_path' => $group->first()->productImages_path

                ]];
            })
            // nếu dùng all() thì sẽ trả về array, mà chỉ muốn trả về colection nên không dùng all()
            ->values();
    }


    public function joinImageById($id)
    {
        $products = $this->model->where('product_combinations.id', $id)
            ->leftJoin('product_images', function ($join) {
                $join->on('product_images.product_combination_id', '=', 'product_combinations.id')->where('product_images.main', 1);
            })
            ->join('product_attributes', 'product_attributes.product_combination_id', '=', 'product_combinations.id')
            ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
            ->join('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
            ->join('products', 'product_combinations.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name',
                'products.description as product_description',
                'attributes.name as attribute_name',
                'attribute_values.value as attribute_value',
                'product_combinations.price as product_price',
                'product_combinations.stock as stock',
                'product_combinations.id as combination_id',
                'product_images.path as productImages_path'
            )
            ->get();

        foreach ($products as $product) {
            if (!$product->productImages_path) {
                $product->productImages_path = '/storage/images/default.png';
            }
        }
        return $this->map($products);
    }
}

