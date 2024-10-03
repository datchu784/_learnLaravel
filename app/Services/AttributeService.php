<?php

namespace App\Services;

use App\Repositories\Interfaces\IAttributeRepository;

class AttributeService extends BaseService
{

    public function __construct(IAttributeRepository $repository)
    {
        $this->repository = $repository;
    }
}
