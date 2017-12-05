<?php
namespace Tenon\Server;
use Tenon\Server\Worker;


/**
 * tcp server based on swoole_server
 * Class Tcp
 * @package Tenon\Server
 */
class Tcp extends SwooleServerAbstract
{
    public function __construct(array $settings)
    {
        parent::__construct($settings);

        $this->init();
    }

    public function init(): self
    {
        // TODO: Implement init() method.
        return $this;
    }

    public function run()
    {
        // before run, do some check and callback
        $this->beforeRun();

        $this->start();
    }

    private function start()
    {
        //Todo: 这里start tcp swoole server

        $server = new \swoole_server("0.0.0.0", $this->port);

        return $server->start();
    }
}