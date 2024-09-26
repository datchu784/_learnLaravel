<?php

namespace App\Services;

use App\Repositories\Interfaces\IPermissionRepository;

class PermissionService extends BaseService
{

    public function __construct(IPermissionRepository $repository)
    {
        $this->repository = $repository;
    }
}
