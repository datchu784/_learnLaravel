<?php

namespace App\Services;

use App\Repositories\Interfaces\IRoleRepository;

class RoleService extends BaseService
{
    

    public function __construct(IRoleRepository $repository)
    {
        $this->repository = $repository;
    }
}
