<?php
namespace Tenon\Bootstrap;

use Tenon\Application\App;
use Tenon\Support\Output;
use Dotenv\Dotenv;


/**
 * 服务启动入口类，分为进程型和命令行型
 * Booter层负责解析env配置，设置全局变量等动作
 * Class Main
 * @package Tenon\Bootstrap
 */
final class Main
{
    /**
     * server入口
     * @param string $envPath
     */
    public static function server($envPath)
    {
        self::init($envPath);
        $app = App::getInstance();
        (new Server($app))->run();
    }

    /**
     * console入口
     * @param string $envPath
     */
    public static function cli($envPath)
    {
        self::init($envPath);
        $app = App::getInstance();
        (new Console($app))->run();
    }

    /**
     * 参数初始化
     * @param string $envPath
     * @return void
     */
    protected static function init($envPath)
    {
        //load env
        try {
            (new Dotenv($envPath))->load();
        } catch (\Exception $e) {
            Output::stderr(['error' => $e->getMessage()]);
            exit();
        }

        //判断env变量
        if (getenv('APP_SECRET') === false) {
            Output::stdout(['warning' => 'APP_SECRET not defined.']);
        }
        if (getenv('APP_PATH') === false) {
            Output::stderr(['error' => 'APP_PATH not defined.']);
            exit();
        }

        //设置全局变量
        define('MAIN_INIT', true);
        define('APP_PATH', getenv('APP_PATH'));
    }
}