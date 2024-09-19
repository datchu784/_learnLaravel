<?php

namespace App\Repositories;


use App\Models\Role;
use App\Repositories\Interfaces\IRoleRepository;


class RoleRepository extends BaseRepository implements IRoleRepository
{
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

}
