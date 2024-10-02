<?php

namespace App\Services;

use App\Repositories\Interfaces\IColorRepository;

class ColorService extends BaseService
{
    public function __construct(IColorRepository $repository)
    {
        $this->repository = $repository;
    }
}
