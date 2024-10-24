<?php

namespace App\Repositories;


use App\Models\AttributeValue;
use App\Repositories\Interfaces\IAttributeValueRepository;


class AttributeValueRepository extends BaseRepository implements IAttributeValueRepository
{
    public function __construct(AttributeValue $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        $attributeValues =  $this->model->all();
        foreach($attributeValues as $attributeValue)
        {
            $attributeValue->attribute;
        }

        return $attributeValues;
    }
}
