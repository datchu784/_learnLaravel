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

    public function isAdmin($id)
    {
        $user = $this->getById($id);
        $user->id_role = 1;
        $user->save();
    }

    public function paginate($perPage = 15)
    {
        $users = $this->model->paginate($perPage);
        foreach ($users as $user) {
            $user->userPermissions;
            $user->role;
        }
        return $users;
    }



}
