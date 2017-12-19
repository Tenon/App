<?php
namespace Tenon\Contracts\Server;

use Closure;


interface ServerContract
{
    public function __construct(array $settings);

    public function run();

    public function setBeforeRunCallback(Closure $callback);

    public function setAfterRunCallback(Closure $callback);
}