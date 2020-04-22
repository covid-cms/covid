<?php

namespace App\Helpers;

use Illuminate\Support\Str as LaravelStrHelper;

class Str extends LaravelStrHelper
{
    public static function make($str)
    {
        return new StringClass($str);
    }

    public static function trim($str, $charlist = ' \t\n\r\0\x0B')
    {
        return trim($str, $charlist);
    }

    public static function ltrim($str, $charlist = ' \t\n\r\0\x0B')
    {
        return ltrim($str, $charlist);
    }

    public static function rtrim($str, $charlist = ' \t\n\r\0\x0B')
    {
        return rtrim($str, $charlist);
    }

    public static function filter($filterType)
    {
        return filter_var($str, $filterType);
    }

    public static function integer($str)
    {
        return (int) $str;
    }
}
