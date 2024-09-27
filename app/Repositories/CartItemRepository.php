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

    public function getCartItem($cardId)
    {
         $user = $this->model->where('cart_id',$cardId)->get();
        return $user;
    }
   
}
