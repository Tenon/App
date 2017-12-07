<?php
namespace Tenon\Service;

use Closure;
use Tenon\Support\Output;


/**
 * 基础组件生产
 * Class ComponentFactory
 * @package Tenon\Service
 */
final class ComponentFactory
{
    public function __construct()
    {

    }

    public function make(string $component): Closure
    {
        return function() use ($component) {
            return new $component();
        };
    }
}