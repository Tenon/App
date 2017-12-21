<?php
namespace Tenon\Bootstrap;

use Tenon\Contracts\Bootstrap\BootstrapContract;
use Tenon\Contracts\Application\ContainerContract;
use Tenon\Server\ServerFactory;
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
    private $runtimePath = '';

    /**
     * @var string
     */
    private $runtimePidPath = '';

    /**
     * @var string
     */
    private $serverType = 'swoole';

    /**
     * @var array
     */
    private $serverConfig = [];

    /**
     * 是否开启daemon模式标识
     * @var bool
     */
    private $daemon = false;

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
        $this->serverManagerRun();
    }

    public function getServerType()
    {
        return $this->serverType;
    }

    public function getApp()
    {
        return $this->app;
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

        //set server type
        $this->serverType = ucfirst($config->get('server_type', $this->serverType));

        //set server process config
        $this->serverConfig = $config->get('server_config', []);

        //check runtime path
        $this->checkRuntimePath();
    }

    /**
     * 检查运行时目录的权限等
     */
    private function checkRuntimePath()
    {
        //runtime path
        $this->runtimePath = env('RUNTIME_PATH', sys_get_temp_dir() . DIRECTORY_SEPARATOR . APP_NAME . DIRECTORY_SEPARATOR . 'runtime');

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
     * server manager init and run
     */
    private function serverManagerRun()
    {
        Output::stdout(['debug' => 'Server.serverManagerRun begin.']);
        $serverManager = (new ServerFactory())->make($this);
        $initResult = $serverManager->init();
        if ($initResult) {
            Output::stderr([
                'error'    => 'Server.serverManager.init fail.',
                'messages' => $initResult
            ]);
            exit();
        }
        $serverManager->run();
    }

}