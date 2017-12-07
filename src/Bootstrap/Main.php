<?php
namespace Tenon\Bootstrap;

use Tenon\Application\App;
use Tenon\Support\Output;


/**
 * 服务启动入口类，分为进程型和命令行型
 * Class Main
 * @package Tenon\Bootstrap
 */
final class Main
{
    /**
     * server入口
     * @param array $aSettings
     */
    public static function server(array $aSettings)
    {
        self::init($aSettings);
        $app = App::getInstance($aSettings);
        (new Server($app))->run();
    }

    /**
     * console入口
     * @param array $aSettings
     */
    public static function cli(array $aSettings)
    {
        self::init($aSettings);
        $app = App::getInstance($aSettings);
        (new Console($app))->run();
    }

    /**
     * 参数初始化
     * @param array $aSettings
     * @return void
     */
    protected static function init(array $aSettings)
    {
        //判断最基础配置是否齐全
        if (!array_key_exists('app_name', $aSettings) || !array_key_exists('base_path', $aSettings)) {
            Output::stderr(["msg" => "config miss app_name or server config."]);
            exit;
        }

        //设置全局变量
        define('APP_NAME', $aSettings['app_name']);
        define('BASE_PATH', $aSettings['base_path']);
        define('FRAMEWORK_PATH', dirname(__DIR__));

    }
}