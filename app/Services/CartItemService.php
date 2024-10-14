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

    public function getAllForCurrentUser()
    {
        $userId = $this->getCurrentUserId();

        $cart = $this->cartRepo->getAllForUser($userId);

        //$cartItems = $this->repository->model->where('cart_id', $cart->first()->id)->latest()->get();
        $cartItems = $this->repository->joinProduct($cart);

        // foreach($cartItems as $cartcarItem)
        // {
        //     $cartItem->product;
        // }
        return $cartItems;

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

        $cartItem = $cart->first()->cartItems
        ->where('product_combination_id',$data['product_combination_id'])->first();
        if(!$cartItem)
        {
            if ($cart)
            {
                $data['cart_id'] = $cart->first()->id;
            }
            return $this->repository->create($data);

        }
        else
        {
            $cartItem->quantity += $data['quantity'];
            $cartItem->save();
        }

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
        return  $this->repository->delete($id);
    }





}
