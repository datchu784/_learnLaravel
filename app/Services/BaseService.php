<?php

namespace App\Services;

abstract class BaseService
{
    public  $repository;

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getById($id)
    {
        return $this->repository->getById($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function paginate($perPage = 4)
    {
        return $this->repository->paginate($perPage);
    }

    public function getAllForCurrentUser()
    {
        $userId = $this->getCurrentUserId();
        return $userId ? $this->repository->getAllForUser($userId) : [];
    }

    public function getByIdForCurrentUser($id)
    {
        $userId = $this->getCurrentUserId();
        return $userId ? $this->repository->getByIdForUser($id, $userId) : $this->getById($id);
    }

    public function createForCurrentUser(array $data)
    {
        $userId = $this->getCurrentUserId();
        if ($userId) {
            $data['user_id'] = $userId;
        }
        return $this->repository->create($data);
    }

    public function updateForCurrentUser($id, array $data)
    {
        $userId = $this->getCurrentUserId();
        return $this->repository->updateForUse($id, $data,$userId);
    }

    public function deleteForCurrentUser($id)
    {
        $userId = $this->getCurrentUserId();
        return $userId ? $this->repository->deleteForUser($id, $userId) : [];
    }


    public function getCurrentUserId()
    {
        return auth()->id();
    }
}
