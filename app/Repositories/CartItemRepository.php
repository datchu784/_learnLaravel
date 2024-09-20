<?php

namespace App\Repositories;

use App\Models\CartItem;
use App\Repositories\Interfaces\ICartItemRepository;


class CartItemRepository extends BaseRepository implements ICartItemRepository
{
    public function __construct(CartItem $model)
    {
        $this->model = $model;
    }

    public function getCartItem($userId)
    {
         $user = $this->model->where('user_id',$userId)->first();
        return $user;
    }
}
