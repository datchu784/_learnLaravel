<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\Interfaces\ICartRepository;


class CartRepository extends BaseRepository implements ICartRepository
{
    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    public function getCart($userId)
    {
         $user = $this->model->where('user_id',$userId)->first();
        return $user;
    }




}
