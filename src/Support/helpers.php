<?php

use Tenon\Application\App;

if (!function_exists('app')) {
    function app()
    {
        return App::getInstance();
    }
}