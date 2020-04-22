<?php

if (!function_exists('str')) {
    function str($str)
    {
        return \Str::make($str);
    }
}
