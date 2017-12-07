<?php
namespace Tenon\Contracts\Service;


/**
 * 配置类接口
 */
interface ConfigureContract
{
    public function get($key);
}