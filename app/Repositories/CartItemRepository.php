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
}
