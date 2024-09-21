<?php

namespace App\Services;

use App\Repositories\Interfaces\ICartItemRepository;
use App\Repositories\Interfaces\ICartRepository;

class CartItemService extends BaseService
{
    public $cartRepo;
    public function __construct(ICartItemRepository $repository, ICartRepository $cartRepo)
    {
        $this->repository = $repository;
        $this->cartRepo = $cartRepo;
    }

    public function getCartItem()
    {
        $userId = auth()->id();
        $cart = $this->cartRepo->getCart($userId);
        return $this->repository->getCartItem($cart->id);
    }
}
