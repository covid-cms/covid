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

    public function find($input)
    {
        if (is_array($input)) {
            return $this->model::where($input)->first();
        }

        return $this->model::find($input);
    }

    public function findOr404($input)
    {
        $object = $this->find($input);
        if (!$object) {
            abort(404);
        }

        return $object;
    }

    public function firstOrCreate($search, array $data)
    {
        $object = $this->find($search);
        if (!$object) {
            $object = $this->create(array_merge($search, $data));
        }

        return $object;
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
