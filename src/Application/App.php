<?php
namespace Tenon\Application;

use Tenon\Contracts\Application\ContainerContract;
use Tenon\Service\ComponentFactory;
use Tenon\Support\Output;


/**
 * App容器
 * Class App
 * @package Tenon\Application
 */
final class App extends Container
{
    /**
     * 容器对象
     * @var \Tenon\Application\App;
     */
    private static $_app;

    /**
     * 版本
     * @var string
     */
    private $version = '0.1';

    /**
     * App Name
     * @var string
     */
    private $appName;

    /**
     * 配置
     * @var array
     */
    private $config = [];

    /**
     * 是否启动标识
     * @var bool
     */
    private $booted = false;

    /**
     * 初始化基础组件
     * @var array
     */
    private $components = [
        'Configure' => \Tenon\Service\Configure::class,  //配置
        //route
        //pdo
        //event
        //log
        //rpc
        //command
        //facade => 开启facade, class_alias
    ];

    /**
     * App容器对象构造入口，每个Worker会使用全局单例的App对象
     * @param array $config 容器初始化配置
     * @param bool $refresh 强制刷新App
     * @return ContainerContract
     */
    public static function getInstance(array $config, $refresh = false): ContainerContract
    {
        if (is_null(self::$_app) || $refresh) {
            self::$_app = new self($config);
        }
        return self::$_app;
    }

    /**
     * 返回App版本
     * @return string
     */
    public function version(): string
    {
        return $this->version;
    }

    /**
     * 返回App容器中的配置
     * @return array
     */
    public function config(): array
    {
        return $this->config;
    }

    /**
     * 构造函数
     * App constructor.
     * @param array $local_config
     */
    private function __construct(array $local_config)
    {
        //初始化配置
        $this->initConfig($local_config);

        //初始化App
        $this->initApp();

        //标记为已启动
        $this->booted = true;
    }

    /**
     * 解析配置，初始化配置
     * 更改配置初始化的方式，采用.env方式
     * @param array $local_config
     */
    protected function initConfig(array $local_config)
    {
        $this->config = $local_config;
    }

    /**
     * 初始化App
     */
    protected function initApp()
    {
        //设置app name
        $this->setAppName(APP_NAME);

        //在容器中初始化App本身
        $this->instance('App', $this);

        //注册组件
        $this->registerComponents();
    }

    protected function setAppName(string $name)
    {
        $this->appName = $name;
    }

    /**
     * 注册基础组件
     */
    protected function registerComponents()
    {
        foreach ($this->components as $facade => $component) {
            $this->bind($facade, (new ComponentFactory())->make($component));
        }
    }

    private function __clone() {}

}