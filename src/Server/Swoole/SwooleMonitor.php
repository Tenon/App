<?php
namespace Tenon\Server;

use Tenon\Support\Output;
use Tenon\Application\App;


class SwooleMonitor
{
    /**
     * @var \Tenon\Contracts\Server\ServerContract
     */
    private $_server;

    private $settings;

    private $app;

    public function __construct(array $server_settings)
    {
        $this->settings = $server_settings;

        $this->init();
    }

    public function setApp(App $app)
    {
        $this->app = $app;
    }

    /**
     * check must configs
     * @return array
     */
    protected function checkSettings()
    {
        $errors = [];
        // swoole_config
        if (!isset($this->settings['swoole_config']) || empty($this->settings['swoole_config'])) {
            $errors[] = ['swoole_config' => 'miss'];
        }
        return $errors;
    }

    protected function checkVersion()
    {
        if (!extension_loaded('swoole')) {
            return false;
        }
        return true;
    }

    protected function init()
    {
        // check settings
        $checkedErrors = $this->checkSettings();
        if ($checkedErrors) {
            Output::stderr($checkedErrors);
            die();
        }
        // check swoole extension exists
        if (!$this->checkVersion()) {
            Output::stderr(['Server.beforeRun' => 'swoole extension not exist!']);
            die();
        }

        // init server
        $this->_server = (new ServerFactory())->make($this->settings)->init();

        return $this;
    }

    protected function daemonize()
    {
        $pid = pcntl_fork();
        if ($pid < 0) {

        } elseif ($pid == 0 ) {

        } else {

        }
    }

    public function run()
    {
        // 两次fork，daemon化monitor进程
        // fork子进程-monitor进程，父进程退出，让子进程daemon化，子的monitor进程负责拉起
        $this->daemonize();

        // swoole monitor进程还是需要调用TCP类的start来启动swoole进程的
        // swoole进程，监听进程信号
        // worker进程中刷新App容器对象
        $this->_server->run();
    }
}