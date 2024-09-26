<?php

namespace App\Services;

use App\Repositories\Interfaces\IUserPermissionRepository;

class UserPermissionService extends BaseService
{


    public function __construct(IUserPermissionRepository $repository)
    {
        $this->repository = $repository;
    }
}
