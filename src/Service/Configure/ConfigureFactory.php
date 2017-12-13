<?php
namespace Tenon\Service\Configure;

use Tenon\Contracts\Service\ConfigureContract;
use Tenon\Support\Output;


class ConfigureFactory
{
    public static function make($path, $type): ConfigureContract
    {
        switch (strtolower($type)) {
            case 'json':
               return new JsonConfigure($path, $type);
                break;
            case 'php':
                return new PhpConfigure($path, $type);
                break;
            default:
                Output::stderr(['msg' => "Configure type: {$type} unknown."]);
                break;
       }
    }

}