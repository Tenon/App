<?php

use Tenon\Application\App;

/**
 * App单例
 */
if (!function_exists('app')) {
    function app()
    {
        return App::getInstance();
    }
}

/**
 * 获取env
 */
if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);
        if (!$value) {
            return $default;
        }
        return $value;
    }
}

if (!function_exists('runtime_path')) {
    function runtime_path($path = '')
    {

    }
}