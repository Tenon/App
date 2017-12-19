<?php
namespace Tenon\Service\Configure;

use Tenon\Service\Component;
use Tenon\Contracts\Service\ConfigureContract;
use Tenon\Support\Output;
use Tenon\Support\Arr;


/**
 * Class Configure
 * @package Tenon\Service\Configure
 */
abstract class Configure extends Component implements ConfigureContract
{
    /**
     * config file dir path
     * @var string
     */
    protected $configPath;

    /**
     * parsed config data
     * @var array
     */
    protected $config = [];

    /**
     * config file type
     * @var string
     */
    protected $configType;

    public function __construct(string $configPath, string $configType)
    {
        if (!is_dir($configPath)) {
            Output::stderr(['error' => "Configure path: {$configPath} is not a dir."]);
            exit();
        }
        $this->configPath = $configPath;
        $this->configType = $configType;
    }

    /**
     * 获取配置目录下所有配置文件内容
     * @Todo: 递归读取目录
     */
    protected function loadConfigDir()
    {
        if (($dir = opendir($this->configPath)) === false)
        {
            Output::stderr(['error' => "{$this->configPath} cannot open."]);
            exit();
        }

        while (($fileName = readdir($dir)) !== false) {
            // . / .. / .xxx.swp or other files start with .
            if ($fileName[0] == '.') {
                continue;
            }
            $filePath =  $this->configPath . DIRECTORY_SEPARATOR . $fileName;
            if (!is_file($filePath) || !is_readable($filePath)) {
                Output::stderr(['warning' => "{$filePath} is not a file or cannot read."]);
                continue;
            }
            $config = $this->loadConfigFiles($filePath);
            if (!is_array($config) || empty($config)) {
                Output::stderr(['warning' => "{$filePath}'s content is not array or empty.'"]);
                continue;
            }
            $this->config = array_merge($this->config, $config);
        }
    }

    public function get($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    abstract protected function loadConfigFiles($filePath): array;
}