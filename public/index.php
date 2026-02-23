<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// maintenance
if (file_exists($maintenance = __DIR__.'/almasah/storage/framework/maintenance.php')) {
    require $maintenance;
}

// autoload
require __DIR__.'/almasah/vendor/autoload.php';

// bootstrap
$app = require_once __DIR__.'/almasah/bootstrap/app.php';

$app->handleRequest(Request::capture());
