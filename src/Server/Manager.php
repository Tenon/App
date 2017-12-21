<?php
namespace Tenon\Server;

use Tenon\Contracts\Server\ServerManagerContract;


/**
 * Class Manager
 * @package Tenon\Server
 */
abstract class Manager implements ServerManagerContract
{

    /**
     * 错误信息收集
     * @var array
     */
    private $errors = [];

    /**
     * 附加错误信息
     * @param string $error
     */
    protected function appendErrors(string $error)
    {
        $this->errors[] = $error;
    }

    protected function getErrors()
    {
        return $this->errors;
    }

    abstract protected function check(): array;
}