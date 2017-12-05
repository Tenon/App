<?php
namespace Tenon\Bootstrap;

use Tenon\Application\App;


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
        $app = App::getInstance(self::init($aSettings));
        (new Server($app))->run();
    }

    /**
     * console入口
     * @param array $aSettings
     */
    public static function cli(array $aSettings)
    {
        $app = App::getInstance(self::init($aSettings));
        (new Console($app))->run();
    }

    /**
     * 参数初始化
     * @param array $aSettings
     * @return mixed
     */
    protected static function init(array $aSettings): array
    {

    }
}