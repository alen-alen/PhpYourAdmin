<?php

use PhpYourAdimn\Core\App;
use PhpYourAdimn\Core\Router;
use PhpYourAdimn\Core\Env\DotEnv;
use PhpYourAdimn\App\Helpers\Session;


require __DIR__ . '/vendor/autoload.php';

Session::start();

(new DotEnv(__DIR__ . '/.env'))->load();

$app = new App(new Router());

$app->run();
