<?php

namespace App\Repositories\Interfaces;

interface IProductVariantRepository
{
    public function getAll();
    public function getById(int $id);
    public function create(array $datatDetails);
    public function update($id, array $newDetails);
    public function delete(int $id);
    public function filter(array $data);

}
