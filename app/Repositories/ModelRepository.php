<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class ModelRepository
{
    protected $model;

    public function __construct()
    {
        $this->define();
    }

    abstract protected function define();

    public function find($id)
    {
        return $this->model::find($id);
    }

    public function create(array $data)
    {
        $object = new $this->model;
        foreach ($data as $attribute => $value) {
            $object->$attribute = $value;
        }
        $object->save();

        return $object;
    }

    public function update(Model $object, array $data)
    {
        foreach ($data as $attribute => $value) {
            $object->$attribute = $value;
        }
        return $object->save();
    }

    public function delete(Model $model)
    {
        return $model->delete();
    }

    public function query(array $options = [])
    {
        return $this->model::query();
    }
}
