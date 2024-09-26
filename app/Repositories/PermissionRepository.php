<?php

namespace App\Repositories;


use App\Models\Permission;
use App\Repositories\Interfaces\IPermissionRepository;


class PermissionRepository extends BaseRepository implements IPermissionRepository
{
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }
}
