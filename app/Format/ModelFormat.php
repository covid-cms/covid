<?php

namespace App\Format;
use Illuminate\Database\Eloquent\Model;

abstract class ModelFormat
{
    abstract public static function format($type, Model $model, array $options = []);
}
