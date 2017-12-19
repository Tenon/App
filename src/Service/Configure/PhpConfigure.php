<?php
namespace Tenon\Service\Configure;

use Tenon\Contracts\Service\ConfigureContract;
use Tenon\Support\Output;


/**
 * php array configure
 */
final class PhpConfigure extends Configure
{
    /**
     * 初始化，加载配置
     * @return ConfigureContract
     */
    public function init(): ConfigureContract
    {
        $this->loadConfigDir();

        return $this;
    }

    /**
     * 从文件中读取配置内容
     * @param $filePath
     * @return mixed
     */
    protected function loadConfigFiles($filePath): array
    {
        try {
            $config = require $filePath;
        } catch (\Exception $e) {
            Output::stderr(['warning' => $e->getMessage()]);
            $config = [];
        }
        return $config;
    }
}