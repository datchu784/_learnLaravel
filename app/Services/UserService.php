<?php

namespace App\Services;

use App\Repositories\Interfaces\ICartRepository;
use App\Repositories\Interfaces\IUserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;



class UserService extends BaseService
{
    public $cartRepo;
    public function __construct(IUserRepository $repository, ICartRepository $cartRepo)
    {
        $this->repository = $repository;
        $this->cartRepo = $cartRepo;
    }

    public function login(string $email, string $password)
    {
        $user = $this->repository->login($email, $password);

        if (!$user) {
            return null;
        }

        $token = $this->createToken($user);
        return $token;
    }
    public function register(array $data)
    {
        $data['id_role'] = 2;
        $user = $this->create($data);

        $token =$this->createToken($user);


        $userIdArray = ['user_id' => $user->id];
        $this->cartRepo->create($userIdArray);

        return $token;
    }

    public function createToken($user)
    {
        $token = JWTAuth::customClaims(['sub=' > $user->id])->fromUser($user);

        return $token;
    }


}
