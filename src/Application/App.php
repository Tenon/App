<?php
namespace Tenon\Application;

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
     * 是否开启daemon模式标识
     * @var bool
     */
    private $daemon = false;

    /**
     * 初始化基础组件
     * @var array
     */
    private $components = [
        'Configure' => \Tenon\Service\Configure::class,
    ];

    /**
     * App容器对象构造入口，每个Worker会使用全局单例的App对象
     * @param array $local_config 容器初始化配置
     * @param bool $refresh 强制刷新App
     * @return App
     */
    public static function getInstance(array $local_config, bool $refresh = false): App
    {
        if (is_null(self::$_app) || $refresh) {
            self::$_app = new self($local_config);
        }
        return self::$_app;
    }

    public function run()
    {

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
     * @param array $local_config
     */
    protected function initConfig(array $local_config)
    {
        //判断基础配置是否齐全
        if (!array_key_exists('app_name', $local_config) || !array_key_exists('server', $local_config)) {
            Output::stderr(["booted" => $this->booted, "msg" => "local_config miss app_name or server config."]);
            exit;
        }

        $this->config = $local_config;
    }

    /**
     * 初始化App
     */
    protected function initApp()
    {
        //设置app name
        $this->setAppName($this->config['app_name']);

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

    private function __destruct() {}

    private function __clone() {}

}