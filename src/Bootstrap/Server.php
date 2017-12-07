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
        $configure = $this->app->make('Configure');
        var_dump($configure);
        exit;
    }

    public function isDaemon()
    {

        return $this->daemon;
    }

    /**
     * 初始化Server Manager
     */
    protected function initServerManager()
    {

    }

    protected function checkRuntimePath()
    {

    }

}