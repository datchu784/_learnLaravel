<?php

namespace App\Repositories;


use App\Models\Attribute;
use App\Repositories\Interfaces\IAttributeRepository;


class AttributeRepository extends BaseRepository implements IAttributeRepository
{
    public function __construct(Attribute $model)
    {
        $this->model = $model;
    }
}
