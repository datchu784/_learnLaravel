<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;


class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function login(string $email, string $password)
    {
        $user = $this->model->where('email', $email)->where('password', $password)->first();
        return $user;
    }

}
