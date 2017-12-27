<?php
namespace Tenon\Server\Swoole;

use Tenon\Support\Constant;
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
    private $booter;

    /**
     * @var App;
     */
    private $app;

    /**
     * swoole server
     * @var \swoole_server
     */
    private $server = null;

    /**
     * @var int
     */
    private $mode = SWOOLE_PROCESS;

    /**
     * @var int
     */
    private $sock_type = SWOOLE_SOCK_TCP;

    /**
     * @var int
     */
    private $MasterPid;

    /**
     * @var int
     */
    private $ManagerPid;

    /**
     * @var array
     */
    private $serverSettings = [
        'reactor_num'     => 2,
        'worker_num'      => 4,
        'max_request'     => 50000,
        'max_connection'  => 50000,
        'task_worker_num' => 2,
    ];

    /**
     * @var array
     */
    private $eventCallback = [];

    /**
     * Manager constructor.
     * @param Server $serverBooter
     */
    public function __construct(Server $serverBooter)
    {
        $this->booter = $serverBooter;
    }

    /**
     * Init.
     * @return array
     */
    public function init(): array
    {
        //init app
        $this->app = $this->booter->getApp();

        //init server settings
        $this->initServerSettings();

        //init event callbacks
        $this->initEventCallbacks();

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
     * 初始化swoole server config
     */
    protected function initServerSettings()
    {
        $configure = $this->app->make('Config');

        //server mode
        $this->mode = $configure->get('mode', $this->mode);

        //server socket type
        $this->sock_type = $configure->get('sock_type', $this->sock_type);

        //server settings
        if ($this->booter->serverSettings) {
            $this->serverSettings = array_merge($this->serverSettings, $this->booter->serverSettings);
        }

        unset($configure);
    }

    /**
     * Init event callbacks.
     */
    protected function initEventCallbacks()
    {
        $this->eventCallback = [
            'Start'       => $this->onStart(),
            'WorkerStart' => $this->onWorkerStart(),
            'Connect'     => $this->onConnect(),
            'Receive'     => $this->onReceive(),
            'WorkerError' => $this->onWorkerError(),
            'Task'        => $this->onTask(),
            'Finish'      => $this->onFinish(),
            'Close'       => $this->onClose(),
        ];
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
        //init swoole server
        $this->setServer();

        //set swoole event callback
        $this->attachEventCallback();

        //start swoole
        $this->server->start();
    }

    protected function setServer()
    {
        if (is_null($this->server)) {
            $this->server = new \swoole_server(
                $this->booter->ip,
                $this->booter->port,
                $this->mode,
                $this->sock_type

            );
            $this->server->set($this->serverSettings);
        }
    }

    protected function attachEventCallback()
    {
        try {
            foreach ($this->eventCallback as $event => $callback)
            {
                $this->server->on($event, $callback);
            }
        } catch (\Exception $e) {
            Output::stderr([
                'step'    => 'Manager.attachEventCallback',
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
            exit();
        }
    }

    /**
     * onStart
     *  1.记录master_pid和manager_pid
     * @return \Closure
     */
    protected function onStart()
    {
        return function(\swoole_server $server) {
            Output::stdout(['debug' => 'Server.onStart']);
            //set pid
            $this->MasterPid  = $server->master_pid;
            $this->ManagerPid = $server->manager_pid;
            //flush pid
            $this->booter->flushPid('Master', $this->MasterPid);
            $this->booter->flushPid('Manager', $this->ManagerPid);
        };
    }

    /**
     * onWorkerStart
     * @return \Closure
     */
    protected function onWorkerStart()
    {
        return function(\swoole_server $server, int $worker_id) {
            Output::stdout(['debug' => 'Server.onWorkerStart']);
        };
    }

    protected function onConnect()
    {
        return function(\swoole_server $server, int $fd, int $reactor_id) {
            Output::stdout(['debug' => 'Server.onConnect']);
        };
    }

    protected function onReceive()
    {
        return function(\swoole_server $server, int $fd, int $reactor_id, string $data) {
            Output::stdout(['debug' => 'Server.onReceive']);
        };
    }

    protected function onWorkerError()
    {
        Output::stdout(['debug' => 'Server.onWorkerError']);
        return function(\swoole_server $server, int $worker_id, int $worker_pid, int $exit_code, int $signal) {

        };
    }

    protected function onTask()
    {
        Output::stdout(['debug' => 'Server.onTask']);
        return function(\swoole_server $server, int $task_id, int $src_worker_id, $data) {

        };
    }

    protected function onFinish()
    {
        return function(\swoole_server $server, int $task_id, string $data) {
            Output::stdout(['debug' => 'Server.onFinish']);
        };
    }

    protected function onClose()
    {
        return function(\swoole_server $server, int $fd, int $reactor_id) {

        };
    }


}