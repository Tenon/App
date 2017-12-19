<?php
namespace Tenon\Bootstrap;

use Tenon\Contracts\Bootstrap\BootstrapContract;
use Tenon\Contracts\Application\ContainerContract;
use Tenon\Contracts\Server\ServerContract;
use Tenon\Support\Output;


final class Server implements BootstrapContract
{
    /**
     * @var ContainerContract
     */
    private $app;

    /**
     * @var string
     */
    private $ip = '0.0.0.0';

    /**
     * @var integer
     */
    private $port;

    /**
     * 运行时目录
     * @var string
     */
    private $runtimePath;

    /**
     * @var
     */
    private $runtimePidPath;

    /**
     * @var
     */
    private $serverType = 'swoole';

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

    public function isDaemon()
    {
        return $this->daemon;
    }

    public function run()
    {
        Output::stdout(['debug' => 'Server.run begin.']);
        //check server config
        $this->initServerConfig();

        //init server manager by factory
        $this->initServerManager();

        //server manager run, raise server processes
        $this->serverManager->run();
    }

    /**
     * 初始化Server Manager
     */
    private function initServerManager()
    {
        Output::stdout(['debug' => 'Server.initServerManager begin.']);
        
    }

    /**
     * 初始化服务配置
     */
    private function initServerConfig()
    {
        Output::stdout(['debug' => 'Server.initServerConfig begin.']);
        /**
         * @var $config \Tenon\Contracts\Service\ConfigureContract
         */
        $config = $this->app->make('Config');

        //check ip & port
        $this->ip = $config->get('ip', $this->ip);
        $this->port = $config->get('port');
        if (!$this->ip || !$this->port) {
            Output::stderr(['error' => "server config ip:{$this->ip} or port:{$this->port} not defined."]);
            exit();
        }

        //check server type
        $this->serverType = ucfirst($config->get('server_type', $this->serverType));
        $this->checkServer();

        //check runtime path
        $this->checkRuntimePath();
    }

    /**
     * 检查运行时目录的权限等
     */
    private function checkRuntimePath()
    {
        //check runtime path exist
        $this->runtimePath = env('RUNTIME_PATH', '');
        if (!$this->runtimePath || !is_dir($this->runtimePath)) {
            Output::stderr(['error' => "runtime path:{$this->runtimePath} not defined or not a dir."]);
            exit();
        }
        //check pid path
        $this->runtimePidPath = $runtimePidPath = $this->runtimePath.DIRECTORY_SEPARATOR.'pid';
        if (!file_exists($runtimePidPath) || !is_dir($runtimePidPath)) {
            if (!mkdir($runtimePidPath, 0777, true)) {
                Output::stderr(['error' => "pid path:{$runtimePidPath} cannot be created."]);
                exit();
            }
        }
        if (!is_writable($runtimePidPath)) {
            Output::stderr(['error' => "pid path:{$runtimePidPath} cannot be write."]);
            exit();
        }
    }

    /**
     * check server type and config
     */
    private function checkServer()
    {

    }

}