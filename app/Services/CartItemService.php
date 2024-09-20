<?php

namespace App\Services;

use App\Repositories\Interfaces\ICartItemRepository;


class CartItemService extends BaseService
{
    public function __construct(ICartItemRepository $repository)
    {
        $this->repository = $repository;
    }
}
