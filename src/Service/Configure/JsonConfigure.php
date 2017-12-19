<?php
namespace Tenon\Service\Configure;

use Tenon\Contracts\Service\ConfigureContract;


final class JsonConfigure extends Configure
{
    /**
     * 初始化
     * @return ConfigureContract
     */
    public function init(): ConfigureContract
    {
        $this->loadConfigDir();

        return $this;
    }

    protected function loadConfigFiles($filePath): array
    {

    }
}