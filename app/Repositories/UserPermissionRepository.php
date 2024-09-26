<?php

namespace App\Repositories;


use App\Models\UserPermission;
use App\Repositories\Interfaces\IUserPermissionRepository;


class UserPermissionRepository extends BaseRepository implements IUserPermissionRepository
{
    public function __construct(UserPermission $model)
    {
        $this->model = $model;
    }
}
