<?php
require('init.php');

use Tenon\Bootstrap\Main;

$aSettings = require('config.php');

Main::server($aSettings);