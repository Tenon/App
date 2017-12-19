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
     * @param string $appPath
     */
    public static function server($appPath)
    {
        self::init($appPath);
        $app = App::getInstance();
        (new Server($app))->run();
    }

    /**
     * console入口
     * @param string $envPath
     */
    public static function cli($appPath)
    {
        self::init($appPath);
        $app = App::getInstance();
        (new Console($app))->run();
    }

    /**
     * 参数初始化
     * @param string $appPath
     * @return void
     */
    protected static function init($appPath)
    {
        //check cli mode
        self::checkSapiEnv();

        //判断env变量
        self::checkEnv($appPath);

        //set define
        self::setGlobalDefine();
    }

    /**
     * 检查运行环境
     */
    protected static function checkSapiEnv()
    {
        if (php_sapi_name() != 'cli') {
            Output::stderr(['error' => 'Only run in cli mode.']);
            exit();
        }
    }

    /**
     * 检查env变量
     * @param string $appPath
     */
    protected static function checkEnv($appPath)
    {
        //load env
        try {
            (new Dotenv($appPath))->load();
        } catch (\Exception $e) {
            Output::stderr(['error' => $e->getMessage()]);
            exit();
        }

        if (getenv('APP_SECRET') === false) {
            Output::stdout(['warning' => 'APP_SECRET not defined.']);
        }
        if (getenv('APP_PATH') === false) {
            Output::stderr(['error' => 'APP_PATH not defined.']);
            exit();
        }
    }

    /**
     * 设置全局变量
     */
    protected static function setGlobalDefine()
    {
        //is main init success
        define('MAIN_INIT', true);
        //app path
        define('APP_PATH', getenv('APP_PATH'));
    }

    public static function getGroup()
    {
        return env('GROUP', 'default');
    }

    public static function getEnv()
    {
        return env('ENV', 'dev');
    }
}