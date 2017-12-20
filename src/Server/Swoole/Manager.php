<?php
namespace Tenon\Server\Swoole;

use Tenon\Support\Output;
use Tenon\Application\App;
use Tenon\Bootstrap\Server;
use Tenon\Server\Manager as ServerManager;


/**
 * Class Manager
 * @package Tenon\Server\Swoole
 */
final class Manager extends ServerManager
{
    /**
     * @var Server
     */
    private $server;

    /**
     * @var App;
     */
    private $app;

    /**
     * Manager constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Init.
     * @return array
     */
    public function init(): array
    {
        //init app
        $this->app = $this->server->getApp();

        // check settings
        $this->checkServerSettings();

        // check swoole extension exists
        $this->checkVersion();

        return [$this->code, $this->message];
    }

    /**
     * check must configs
     * @return array
     */
    protected function checkServerSettings()
    {
//        $errors = [];
//        // swoole_config
//        if (!isset($this->settings['swoole_config']) || empty($this->settings['swoole_config'])) {
//            $errors[] = ['swoole_config' => 'miss'];
//        }
//        return $errors;
    }

    protected function checkVersion()
    {
        if (!extension_loaded('swoole')) {
            $this->code = 1;
            $this->message = 'swoole extension not exist';
        }
    }

    /**
     * Manager run.
     */
    public function run()
    {
        // swoole monitor进程还是需要调用TCP类的start来启动swoole进程的
        // swoole进程，监听进程信号
        // worker进程中刷新App容器对象
    }
}