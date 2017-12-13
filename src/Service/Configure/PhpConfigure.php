<?php
namespace Tenon\Service\Configure;
use Tenon\Support\Output;


/**
 * php array configure
 */
final class PhpConfigure extends BaseConfigure
{
    protected function loadConfigFiles($filePath): array
    {
        try {
            $config = require $filePath;
        } catch (\Exception $e) {
            Output::stderr(['warning' => $e->getMessage()]);
            $config = [];
        }
        return $config;
    }
}