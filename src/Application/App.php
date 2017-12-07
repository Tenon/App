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
     * 配置文件目录
     * @var string
     */
    private $configPath;

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
     * @param bool $refresh 强制刷新App
     * @return ContainerContract
     */
    public static function getInstance($refresh = false): ContainerContract
    {
        //before init check
        if (!defined('MAIN_INIT')) {
            Output::stderr(['msg' => 'Main not init yet, App init failed.']);
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
        $this->initConfigure();

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
    protected function initConfigure()
    {
        //配置文件目录定位
        $this->configPath = getenv('CONFIG_PATH') === false ? APP_PATH . '/config' : getenv('CONFIG_PATH');
    }

    /**
     * 初始化App
     */
    protected function initApp()
    {
        //设置app name
        $this->setAppName();

        //在容器中初始化App本身
        $this->instance('App', $this);

        //注册组件
        $this->registerComponents();
    }

    protected function setAppName()
    {

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