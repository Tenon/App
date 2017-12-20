<?php
namespace Tenon\Server;

use Tenon\Contracts\Server\ServerManagerContract;


/**
 * Class Manager
 * @package Tenon\Server
 */
abstract class Manager implements ServerManagerContract
{
    protected $code;

    protected $message;

    abstract protected function checkServerSettings();
}