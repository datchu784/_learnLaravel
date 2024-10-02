<?php

namespace App\Repositories\Interfaces;

interface IAttributeRepository
{
    public function getAll();
    public function getById(int $id);
    public function create(array $datatDetails);
    public function update($id, array $newDetails);
    public function delete(int $id);
}