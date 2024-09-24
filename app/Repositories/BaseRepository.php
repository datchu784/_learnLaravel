<?php

namespace App\Repositories;

abstract class BaseRepository
{
    public  $model;

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model->find($id);
        //null = false, not null = true
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function paginate($perPage = 4)
    {
        return $this->model->paginate($perPage);
    }

    public function getForUser($userId)
    {
        return $this->model->where('user_id', $userId);
    }

    public function getAllForUser($userId)
    {
        return $this->getForUser($userId)->get();
    }

    public function getByIdForUser($id, $userId)
    {
        return $this->getForUser($userId)->find($id);
    }

    public function updateForUser($id, array $data,$userId)
    {
        $record = $this->model->where('user_id', $userId)->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    public function deleteForUser($id, $userId)
    {
        return $this->model->where('user_id', $userId)->where('id', $id)->delete();
    }
}
