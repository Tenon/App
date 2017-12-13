<?php
namespace Tenon\Contracts\Application;


interface ContainerContract
{
    public function make($abstract, array $parameters = [], $isSingleton = true);

    public static function getInstance($refresh = false): self;

    public function version(): string;

}