<?php
namespace Tenon\Server\Rawphp;

use Tenon\Bootstrap\Server;
use Tenon\Contracts\Server\ServerManagerContract;


/**
 * Class Manager
 * @package Tenon\Server\Rawphp
 */
final class Manager implements  ServerManagerContract
{

    /**
     * @var Server
     */
    private $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Init
     * @return mixed
     */
    public function init(): array
    {
        return [];
    }

    public function run()
    {
        // TODO: Implement run() method.
    }
}