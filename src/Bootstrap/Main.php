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
     * @var string
     */
    private static $appPath;

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
     * @param string $appPath
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
        Output::stdout(['debug' => 'Main.init begin.']);
        self::$appPath = $appPath;

        //check cli mode
        self::checkSapiEnv();

        //check app path
        self::checkAppPath();

        //check env
        self::checkEnv();

        //set define
        self::setGlobalDefine();
    }

    /**
     * check app path
     */
    protected static function checkAppPath()
    {
        if (!is_dir(self::$appPath) || !is_readable(self::$appPath)) {
            Output::stderr(['error' => "app path: " . self::$appPath . "is not a dir or readable."]);
            exit();
        }
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
     */
    protected static function checkEnv()
    {
        //load env
        try {
            (new Dotenv(self::$appPath))->load();
        } catch (\Exception $e) {
            Output::stderr(['error' => $e->getMessage()]);
            exit();
        }

        if (getenv('APP_SECRET') === false) {
            Output::stdout(['warning' => 'APP_SECRET not defined.']);
        }
        if (getenv('APP_PATH') === false) {
            Output::stdout(['debug' => 'APP_PATH not defined.']);
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
        define('APP_PATH', env('APP_PATH', self::$appPath));
    }

    public static function getGroup()
    {
        return env('GROUP', 'default');
    }

    public static function getEnv()
    {
        return env('ENV', 'dev');
    }

    /**
     * 获取版本号
     * @return string
     */
    public static function getLibVersion()
    {
        $version = 'unknown';
        $path = APP_PATH . DIRECTORY_SEPARATOR . 'composer.lock';
        if (!is_file($path) || !is_readable($path)) {
            Output::stderr(['error' => "composer lock file: {$path} not readable."]);
        } else {
            $content = json_decode(file_get_contents($path), true);
            $packages = $content['packages'] ?? [];
            foreach ($packages as $package) {
                if ($package['name'] == 'tenon/app') {
                    $version = $package['version'];
                }
            }
        }
        return $version;
    }
}