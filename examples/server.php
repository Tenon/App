<?php
require('init.php');
use Tenon\Server\ServerFactory;

$aSettings = require('config.php');

$server = (new ServerFactory())->make($aSettings['server']);

$server->run();

