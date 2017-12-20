<?php
namespace Tenon\Contracts\Server;

use Tenon\Bootstrap\Server;


/**
 * Interface ServerManagerContract
 * @package Tenon\Contracts\Server
 */
interface ServerManagerContract
{
    public function __construct(Server $server);

    public function init(): array;

    public function run();
}