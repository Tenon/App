<?php
namespace Tenon\Service\Configure;

use Tenon\Contracts\Service\ConfigureContract;
use Tenon\Support\Output;


class ConfigureFactory
{
    public static function make($path, $type): ConfigureContract
    {
        $class = ucfirst($type) . "Configure";
        $class = __NAMESPACE__ . "\\$class";
        if (!class_exists($class)) {
            Output::stderr([
                'error' => "Configure type: {$type} not exists.",
                'class' => $class,
            ]);
            exit();
        }
        return new $class($path, $type);
    }

}