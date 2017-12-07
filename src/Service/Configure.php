<?php
namespace Tenon\Service;


/**
 * 配置类
 * 全局配置的获取应该由Configure来处理而不是App
 * Class Configure
 * @package Tenon\Service
 */
class Configure extends BaseComponent
{
    public function __construct()
    {

    }

    /**
     * 获取配置
     * @param string $key
     * @return string/integer/array
     */
    public function get(string $key)
    {
        var_dump('get');
    }

}