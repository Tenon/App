<?php
namespace Tenon\Bootstrap;

use Tenon\Contracts\Bootstrap\BootstrapContract;
use Tenon\Contracts\Application\ContainerContract;
use Tenon\Contracts\Server\ServerContract;


final class Server implements BootstrapContract
{

    /**
     * @var ContainerContract
     */
    private $app;

    /**
     * 是否开启daemon模式标识
     * @var bool
     */
    private $daemon = false;

    /**
     * 管理进程模型的对象
     * @var ServerContract
     */
    private $serverManager;

    public function __construct(ContainerContract $app)
    {
        $this->app = $app;
    }

    public function run()
    {
        //check server config
        $this->checkServerConfig();

        //init server manager by factory

        //server manager run, raise server processes

    }

    protected function isDaemon()
    {
        return $this->daemon;
    }

    /**
     * 初始化Server Manager
     */
    private function initServerManager()
    {

    }

    private function checkServerConfig()
    {
        $this->checkRuntimePath();
    }

    private function checkRuntimePath()
    {

    }

}