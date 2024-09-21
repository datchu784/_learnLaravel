<?php

namespace App\Repositories\Interfaces;

interface ICartRepository
{
    public function getAll();
    public function getById(int $id);
    public function create(array $dataDetails);
    public function update($id, array $newDetails);
    public function delete(int $id);
    public function getCart($userId);
}
