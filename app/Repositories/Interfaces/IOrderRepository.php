<?php

namespace App\Repositories\Interfaces;

interface IOrderRepository
{
    public function getAllForUser($userId);
    public function getByIdForUser($id, $userId);
    public function create(array $dataDetails);
    public function deleteForUser($id, $userId);
    public function joinOrderDetail($id, $userId);

}
