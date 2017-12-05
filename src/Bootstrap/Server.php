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
        // TODO: Implement run() method.
    }

    /**
     * 初始化Server Manager
     */
    protected function initServerManager()
    {

    }

}