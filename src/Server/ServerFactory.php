<?php
namespace Tenon\Server;

use Tenon\Contracts\Server\ServerContract;
use Tenon\Bootstrap\Server;


/**
 * Class ServerFactory
 * @package Tenon\Server
 */
class ServerFactory
{
    /**
     * @param Server $server
     * @return ServerContract
     */
    public function make(Server $server): ServerContract
    {
        $serverCore = __NAMESPACE__ . "\\" . ucfirst($server->getServerType()) . "\\Manager";
        return new $serverCore($server);
    }
}