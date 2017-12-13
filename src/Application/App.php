<?php
namespace Tenon\Application;

use Tenon\Contracts\Application\ContainerContract;
use Tenon\Service\ComponentFactory;
use Tenon\Support\Output;
use Tenon\Service\Configure\ConfigureFactory;


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
     * @var string
     */
    private $basePath;

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
     * @param bool $refresh 强制刷新App
     * @return ContainerContract
     */
    public static function getInstance($refresh = false): ContainerContract
    {
        //before init check
        if (!defined('MAIN_INIT')) {
            Output::stderr(['error' => 'Main not init yet, App init failed.']);
            exit;
        }
        //init app
        if (is_null(self::$_app) || $refresh) {
            self::$_app = new self();
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
     * 构造函数
     * App constructor.
     */
    private function __construct()
    {
        //初始化配置
        $this->initConfig();

        //初始化App
        $this->initApp();

        //标记为已启动
        $this->booted = true;
    }

    /**
     * 初始化配置组件
     * 解析配置，初始化配置
     * 从env中读到基础配置后，进行配置文件查询、解析
     */
    protected function initConfig()
    {
        //配置文件目录定位
        $configPath = getenv('CONFIG_PATH') === false ? APP_PATH . '/config' : getenv('CONFIG_PATH');

        //配置文件类型
        $configType = getenv('CONFIG_TYPE') === false ? 'php' : getenv('CONFIG_TYPE');

        //init configure
        $configure = ConfigureFactory::make($configPath, $configType)->init();

        //include into container
        $this->instance('Configure', $configure);
    }

    /**
     * 初始化App
     */
    protected function initApp()
    {
        //设置app name
        $this->setAppName();

        //注册组件
        $this->registerComponents();
    }

    protected function setAppName()
    {
        $this->appName = $this->make('Configure')->get('app_name');
        if (!$this->appName) {
            Output::stderr(['error' => 'app_name config not defined.']);
            exit();
        }
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