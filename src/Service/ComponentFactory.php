<?php
namespace Tenon\Service;

use Tenon\Contracts\Component\ComponentContract;
use Tenon\Contracts\Application\ContainerContract;
use Closure;


final class ComponentFactory
{
    public function __construct()
    {

    }

    public function make(ComponentContract $component): Closure
    {
        return function(ContainerContract $app) use ($component) {
            return new $component($app);
        };
    }
}