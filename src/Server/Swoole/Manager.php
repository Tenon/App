<?php
namespace Tenon\Server\Swoole;

use Tenon\Support\Constant;
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

        // check
        return $this->check();
    }

    /**
     * check server settings and others.
     * @return array
     */
    protected function check(): array
    {
        //check swoole extension
        $this->checkExtension();

        return $this->getErrors();
    }

    /**
     * 检查swoole扩展是否安装
     * @return void
     */
    protected function checkExtension()
    {
        if (!extension_loaded('swoole')) {
            $this->appendErrors(Constant::MSG_SERVER_INIT_WITHOUT_SWOOLE_EXT);
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