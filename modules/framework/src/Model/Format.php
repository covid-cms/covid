<?php

namespace Covid\Framework\Model;

use Illuminate\Database\Eloquent\Model;

abstract class Format
{
    abstract public static function format($type, Model $model, array $options = []);
}
