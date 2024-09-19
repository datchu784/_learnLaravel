<?php

namespace App\Services;

use App\Repositories\Interfaces\IUserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;



class UserService extends BaseService
{
    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
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
        $user = $this->create($data);

        $token =$this->createToken($user);

        return $token;
    }

    public function createToken($user)
    {
        $token = JWTAuth::customClaims(['sub=' > $user])->fromUser($user);

        return $token;
    }


}
