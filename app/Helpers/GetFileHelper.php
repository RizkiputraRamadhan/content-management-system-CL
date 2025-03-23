<?php

if (!function_exists('getFile')) {
    function getFile($path)
    {
        return asset($path);;
    }
}
