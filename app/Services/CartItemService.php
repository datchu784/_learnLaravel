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

    // public function getCartItem()
    // {
    //     $userId = $this->getCurrentUserId();
    //     $cart = $this->cartRepo->getCart($userId);
    //     return $this->repository->getCartItem($cart->id);
    // }

    public function getAllForCurrentUser()
    {
        $userId = $this->getCurrentUserId();

        $cart = $this->cartRepo->getAllForUser($userId);

        $cartItem = $this->repository->model->where('cart_id', $cart->first()->id)->get();
        return $cartItem;

    }

    public function getByIdForCurrentUser($id)
    {
        $cartItem = $this->getAllForCurrentUser();
        return $cartItem->find($id);
    }

    public function createForCurrentUser(array $data)
    {
        $userId = $this->getCurrentUserId();
        $cart = $this->cartRepo->getAllForUser($userId);
        if ($cart) {
            $data['cart_id'] = $cart->first()->id;
        }
       return $this->repository->create($data);
       
    }

    public function updateForCurrentUser($id, array $data)
    {
        $userId = $this->getCurrentUserId();
        $cart = $this->cartRepo->getAllForUser($userId);
        if ($cart) {
            $data['cart_id'] = $cart->first()->id;
        }
        return $this->repository->update($id, $data);
    }

    public function deleteForCurrentUser($id)
    {
        $cartItem = $this->getAllForCurrentUser();
        return $cartItem->find($id)->delete();
    }





}
