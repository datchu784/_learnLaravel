<?php

namespace App\Repositories;


use App\Models\Size;
use App\Repositories\Interfaces\ISizeRepository;


class SizeRepository extends BaseRepository implements ISizeRepository
{
    public function __construct(Size $model)
    {
        $this->model = $model;
    }
}
