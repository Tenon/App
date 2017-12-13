<?php
namespace Tenon\Contracts\Service;


/**
 * 配置类接口
 */
interface ConfigureContract
{
    public function init(): self;

    public function get($key, $default = null);
}