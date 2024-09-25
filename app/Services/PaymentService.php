<?php

namespace App\Services;

use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\IPaymentRepository;
use App\Repositories\Interfaces\IUserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class PaymentService extends BaseService
{
    public $orderRepo;
    public $userRepo;

    public function __construct(IPaymentRepository $repository, IOrderRepository $orderRepo, IUserRepository $userRepo)
    {
        $this->repository = $repository;
        $this->orderRepo = $orderRepo;
        $this->userRepo = $userRepo;
    }

    public function create(array $data)
    {
        DB:: beginTransaction();
        try{
            $userId = $this->getCurrentUserId();
            $data['sender_id'] = $userId;

            $orders=[
                'user_id'=>$userId,
                'total_amount'=> $data['amount'],
                'status'=> 'yet received goods',
            ];
            $this->orderRepo->create($orders);


            $user = $this->userRepo->getById($userId);
            $user['money'] -= $data['amount'];
            $user->save();

            $recipientUser = $this->userRepo->getById($data['recipient_id']);
            $recipientUser['money'] += $data['amount'];
            $recipientUser->save();

            $payment = $this->repository->create($data);

            DB:: commit();
            return $payment;


        }
        catch(Exception $e){
            DB:: rollBack();
            throw $e;

        }

    }
}
