<?php

namespace App\Repositories;


use App\Models\ProductVariant;
use App\Repositories\Interfaces\IProductVariantRepository;


class ProductVariantRepository extends BaseRepository implements IProductVariantRepository
{
    public function __construct(ProductVariant $model)
    {
        $this->model = $model;
    }

    public function filter(array $data)
    {

        $query = $this->model->query();


        if (isset($data['size_id'])) {
            $query->where('size_id', $data['size_id']);
        }

        if (isset($data['color_id'])) {
            $query->where('color_id', $data['color_id']);
        }

        if (isset($data['attribute_id'])) {
            $query->where('attribute_id', $data['attribute_id']);
        }

        if (isset($data['min_price']) || isset($data['max_price'])) {
            $query->whereHas('product', function ($q) use ($data) {
                if (isset($data['min_price']) && $data['min_price'] > 0) {
                    $q->whereRaw('products.price + product_variants.price_adjustment >= ?', [$data['min_price']]);
                }

                if (isset($data['max_price']) && $data['max_price'] > 0) {
                    $q->whereRaw('products.price + product_variants.price_adjustment <= ?', [$data['max_price']]);
                }
            });
        }

        return $query->get();
    }
}
