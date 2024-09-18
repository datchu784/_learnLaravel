<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;


interface IProductRepository
{
    public function getAll();
    public function getById(int $id);
    public function create(array $productDetails);
    public function update($id, array $newDetails);
    public function delete(int $id);
    public function updateQuantity($id, int $quantity);
    public function search($keyword);
}
