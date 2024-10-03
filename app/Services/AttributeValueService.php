<?php

namespace App\Services;

use App\Repositories\Interfaces\IAttributeValueRepository;

class AttributeValueService extends BaseService
{
    public function __construct(IAttributeValueRepository $repository)
    {
        $this->repository = $repository;
    }
}
