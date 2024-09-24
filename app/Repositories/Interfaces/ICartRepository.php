<?php

namespace App\Repositories\Interfaces;

interface ICartRepository
{
    public function getAllForUser($userId);
    public function create(array $dataDetails);
    public function updateForUser($id, array $newDetails, $userId);
    public function deleteForUser($id, $userId);
    public function getCart($userId);
}
