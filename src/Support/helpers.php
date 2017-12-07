<?php

use Tenon\Application\App;

/**
 * 需要改变App的初始化方式，确保能够真正全局唯一单例
 */
if (!function_exists('app')) {
    function app()
    {
        return App::getInstance();
    }
}