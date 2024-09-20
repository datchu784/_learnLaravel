<?php

namespace App\Repositories;



abstract class BaseRepository
{
    protected  $model;

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

    public function paginate($perPage = 15)
    {
        return $this->model->paginate($perPage);
    }
}
