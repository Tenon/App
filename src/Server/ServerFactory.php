<?php
namespace Tenon\Server;

use Tenon\Contracts\Server\ServerManagerContract;
use Tenon\Bootstrap\Server;


/**
 * Class ServerFactory
 * @package Tenon\Server
 */
class ServerFactory
{
    /**
     * @param Server $server
     * @return ServerManagerContract
     */
    public function make(Server $server): ServerManagerContract
    {
        $serverCore = __NAMESPACE__ . "\\" . ucfirst($server->serverType) . "\\Manager";
        return new $serverCore($server);
    }
}