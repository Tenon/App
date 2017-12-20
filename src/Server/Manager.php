<?php
namespace Tenon\Server;

use Tenon\Contracts\Server\ServerManagerContract;
use Tenon\Support\Constant;


/**
 * Class Manager
 * @package Tenon\Server
 */
abstract class Manager implements ServerManagerContract
{

    /**
     * error code
     * @var integer
     */
    protected $code = Constant::CODE_SERVER_INIT_OK;

    /**
     * erroe message
     * @var string
     */
    protected $message = '';

    abstract protected function checkServerSettings();
}