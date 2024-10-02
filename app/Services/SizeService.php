<?php

namespace App\Services;

use App\Repositories\Interfaces\ISizeRepository;

class SizeService extends BaseService
{
    public function __construct(ISizeRepository $repository)
    {
        $this->repository = $repository;
    }
}
