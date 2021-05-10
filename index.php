<?php

use PhpYourAdimn\Core\App;
use PhpYourAdimn\Core\Router;


require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/core/helpers.php';

session_start();

$app = new App(new Router());

$app->run();
