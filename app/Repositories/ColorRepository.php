<?php

namespace App\Repositories;


use App\Models\Color;
use App\Repositories\Interfaces\IColorRepository;


class ColorRepository extends BaseRepository implements IColorRepository
{
    public function __construct(Color $model)
    {
        $this->model = $model;
    }
}
