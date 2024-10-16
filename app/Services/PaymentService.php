<?php

namespace App\Services;

use App\Repositories\Interfaces\ICartItemRepository;
use App\Repositories\Interfaces\ICartRepository;
use App\Repositories\Interfaces\IOrderDetailRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\IPaymentRepository;
use App\Repositories\Interfaces\IProductCombinationRepository;
use App\Repositories\Interfaces\IUserRepository;
use Exception;
use Illuminate\Support\Facades\DB;


class PaymentService extends BaseService
{
    public $orderRepo;
    public $userRepo;
    public $productRepo;
    public $orderDetailRepo;
    protected $cartItemRepo;
    protected $cartRepo;

    public function __construct(
        IPaymentRepository $repository,
        IOrderRepository $orderRepo,
        IUserRepository $userRepo,
        IProductCombinationRepository $productRepo,
        IOrderDetailRepository $orderDetailRepo,
        ICartItemRepository $cartItemRepo,
        ICartRepository $cartRepo)
    {
        $this->repository = $repository;
        $this->orderRepo = $orderRepo;
        $this->userRepo = $userRepo;
        $this->productRepo = $productRepo;
        $this->orderDetailRepo = $orderDetailRepo;
        $this->cartItemRepo = $cartItemRepo;
        $this->cartRepo = $cartRepo;
    }

    public function createPayment(array $payment, array $orderDetails)
    {
        DB:: beginTransaction();
        try{
            $userId = $this->getCurrentUserId();
            $payment['sender_id'] = $userId;

            $orders=[
                'user_id'=>$userId,
                'total_amount'=> 0,
                'status'=> 'yet received goods',
            ];
            $order = $this->orderRepo->create($orders);
            foreach($orderDetails as $orderDetail)
            {
                $orderDetail['order_id'] = $order->id;
                $payment['order_id'] = $orderDetail['order_id'];
                $product = $this->productRepo->getById($orderDetail['product_combination_id']);

                $cart = $this->cartRepo->getAllForUser($userId);
                $cartItem = $this->cartItemRepo->getCartItem($cart->first()->id)
                ->where('product_combination_id',$orderDetail['product_combination_id'])->first();
                if($cartItem)
                {
                    $cartItem->quantity -=  $orderDetail['quantity'];
                }

                if($cartItem->quantity == 0)
                {
                    $this->cartItemRepo->model->destroy($cartItem->id);
                }
                else
                {
                    $cartItem->save();
                }



                if($product->stock >= $orderDetail['quantity'])
                {
                    $orderDetail['price'] = $product->price * $orderDetail['quantity'];
                    $product->stock -= $orderDetail['quantity'];
                    $order->total_amount += $orderDetail['price'];
                    $this->orderDetailRepo->create($orderDetail);
                    $product->save();
                }
                else
                {
                    throw new Exception('Số lượng sản phẩm không đủ');
                }
           }

            if($payment['amount'] != $order->total_amount)
            {
                throw new Exception('Tính sai total_amount');

            }
            $order->save();

            $user = $this->userRepo->getById($userId);
            if($user['money'] < $payment['amount'] )
            {
                throw new Exception('Không đủ tiền');
            }

            $user['money'] -= $payment['amount'];
            $user->save();

            $recipientUser = $this->userRepo->getById($payment['recipient_id']);
            $recipientUser['money'] += $payment['amount'];
            $recipientUser->save();

            $payment = $this->repository->create($payment);

            DB:: commit();
            return $payment;


        }
        catch(Exception $e){
            DB:: rollBack();
            throw $e;

        }

    }
}
