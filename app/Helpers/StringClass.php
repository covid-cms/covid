<?php

namespace App\Helpers;

use App\Helpers\Str;

class StringClass
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __call($method, $params = [])
    {
        $params = array_merge([$this->value], $params);
        $this->value = call_user_func_array([Str::class, $method], $params);

        if (gettype($this->value) != 'string') {
            return $this->value;
        }

        return $this;
    }

    public function __toString()
    {
        return $this->value;
    }
}
