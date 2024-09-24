<?php

namespace App\Services;

use App\Repositories\Interfaces\ICartRepository;


class CartService extends BaseService
{
    public function __construct(ICartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getCart()
    {
        $userId = auth()->id();
        return $this->repository->getCart($userId);
    }
    
}
