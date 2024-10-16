<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\IOrderRepository;


class OrderRepository extends BaseRepository implements IOrderRepository
{
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function orderStatus($userId,$status)
    {
        $items = $this->getAllForUser($userId)->where('status',$status);

        return $items;
    }

    public function joinOrderDetail($id, $userId)
    {
        $order = $this->model
        ->where('user_id', $userId)
        ->where('orders.id', $id)
        ->leftJoin('order_details', 'order_details.order_id', '=', 'orders.id')
        ->join('product_combinations', 'product_combinations.id', '=', 'order_details.product_combination_id')
        ->join('products', 'product_combinations.product_id', '=', 'products.id')
        ->join('product_attributes', 'product_attributes.product_combination_id', '=', 'product_combinations.id')
        ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
        ->join('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
        ->select('orders.*')
        ->select(
            'products.name as product_name',
            'attributes.name as attribute_name',
            'attribute_values.value as attribute_value',
            'product_combinations.id as combination_id',
            'product_combinations.price as product_price',
            'order_details.quantity as quantity',
            'order_details.price as products_amount',
            'orders.total_amount as total_amount',
            'orders.created_at as created_at',
            'orders.updated_at as updated_at',)
        ->get();

        if ($order) {

            return $this->map($order);
        } else {
            return null;
        }

    }

    public function map($joins)
    {
        return $joins
            ->groupBy('combination_id')
            ->map(function ($group) {
                return [
                'product_combination_id' => $group->first()->combination_id,
                'product_name' => $group->first()->product_name,
                'attributes' => $group->pluck('attribute_value', 'attribute_name')->toArray(),
                'product_price' => $group->first()->product_price,
                'quantity' => $group->first()->quantity,
                'products_amount' => $group->first()->products_amount,
                'total_amount' => $group->first()->total_amount,
                'created_at' => $group->first()->created_at,
                'updated_at' => $group->first()->updated_at,
                ];
            })
            ->values()
            ->all();
    }

    public function getAll()
    {
        return parent::getAll()->latest() ;
    }


}
