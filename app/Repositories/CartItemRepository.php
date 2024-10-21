<?php

namespace App\Repositories;

use App\Models\CartItem;
use App\Repositories\Interfaces\ICartItemRepository;
use Illuminate\Support\Facades\DB;

class CartItemRepository extends BaseRepository implements ICartItemRepository
{
    public function __construct(CartItem $model)
    {
        $this->model = $model;
    }

    public function getCartItem($cardId)
    {
         $user = $this->model->where('cart_id',$cardId)->get();
        return $user;
    }

    public function joinProduct($cart)
    {
        $cartItem =  $this->model->where('cart_id', $cart->first()->id)
        ->join('product_combinations', 'product_combinations.id', '=', 'cart_items.product_combination_id')
        ->join('products', 'product_combinations.product_id', '=', 'products.id')
        ->join('product_attributes', 'product_attributes.product_combination_id', '=', 'product_combinations.id')
        ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
        ->join('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
        ->leftJoin('product_images', function ($join) {
            $join->on('product_images.product_combination_id', '=', 'product_combinations.id')->where('product_images.main', 1);
        })
        ->select(
            'cart_items.id as cart_item_id',
            'products.name as product_name',
            'attributes.name as attribute_name',
            'attribute_values.value as attribute_value',
            'product_combinations.id as combination_id',
            'cart_items.quantity as quantity',
            'product_combinations.price as product_price',
            'product_images.path as product_image',
            DB::raw('(cart_items.quantity * product_combinations.price) as total_price',
        ),
            'cart_items.created_at as created_at',
            'cart_items.updated_at as updated_at',
        )
        ->latest()
        ->get();

        return $this->map($cartItem);
    }

    public function map($joins)
    {
        return $joins
            ->groupBy('combination_id')
            ->map(function ($group) {
                return [
                'cart_item_id' => $group->first()->cart_item_id,
                'product_combination_id' => $group->first()->combination_id,
                'product_name' => $group->first()->product_name,
                'attributes' => $group->pluck('attribute_value', 'attribute_name')->toArray(),
                'product_price' => $group->first()->product_price,
                'quantity' => $group->first()->quantity,
                'total_price' => $group->first()->total_price,
                'product_image' => $group->first()->product_image ?? '/storage/images/default.png',
                'created_at' => $group->first()->created_at,
                'updated_at' => $group->first()->updated_at,
                ];
            })
            ->values();

    }

}
