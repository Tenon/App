<?php
namespace Tenon\Service\Configure;

use Tenon\Service\BaseComponent;
use Tenon\Contracts\Service\ConfigureContract;


/**
 * Base Configure
 */
abstract class BaseConfigure extends BaseComponent implements ConfigureContract
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
        $this->configPath = $configPath;
        $this->configType = $configType;
    }

    abstract public function loadConfigFiles();
}