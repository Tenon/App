<?php
namespace Tenon\Application;

use Tenon\Server\SwooleMonitor;
use Tenon\Contracts\Server\ServerContract;
use Tenon\Support\Output;


class App
{
    private static $_app = null;

    private $_components;

    private $_server_monitor;

    private $_config;

    private $booted = false;

    private function config()
    {
        return $this->_config;
    }

    private function __construct(array $local_config)
    {
        $this->_config = $local_config;

        $this->init();
    }

    protected function init()
    {
        $this->initConfig();

        $this->initServer();

        $this->booted = true;
    }

    protected function initConfig()
    {

    }

    protected function initServer()
    {
        //Todo: 这里改下，应该是直接去起swoole monitor，然后由monitor来起server，这样比较合理
        $this->_server_monitor = (new SwooleMonitor($this->config()))->init($this);
    }

    public static function getInstance(array $local_config = [])
    {
        if (is_null(self::$_app) && !empty($local_config)) {
            self::$_app = new self($local_config);
        }
        return self::$_app;
    }

    public static function refreshApp()
    {

    }

    public function run()
    {
        if ($this->_server_monitor && $this->_server_monitor instanceof SwooleMonitor) {
            $this->_server_monitor->run();
        } else {
            Output::error(['App.run' => 'fail with error server monitor']);
            die();
        }
    }

}