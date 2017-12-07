<?php
/**
 * 入口文件
 */

$appPath = dirname(__DIR__);

//引入autoload
require dirname($appPath) . '/vendor/autoload.php';

use Tenon\Bootstrap\Main;

Main::server($appPath);