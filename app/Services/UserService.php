<?php

namespace App\Services;

use App\Repositories\UserRepository;


class UserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function register($data)
    {
        // $result = $this->repository->create($data);
        // return $result;
    }

    public function test()
    {
        return 'ok';

    }
}
