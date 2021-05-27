<?php

use DI\ContainerBuilder;
use PhpYourAdimn\Core\App;
use PhpYourAdimn\Core\Router;
use PhpYourAdimn\Core\Env\DotEnv;
use PhpYourAdimn\App\Helpers\Session;
use PhpYourAdimn\Core\Database\Connection;
use PhpYourAdimn\Core\Request;

require __DIR__ . '/vendor/autoload.php';

(new DotEnv(__DIR__ . '/.env'))->load();

$builder = new ContainerBuilder();

$builder->addDefinitions(__DIR__ . './core/config.php');

$container=$builder->build();

$app = new App(new Router($container));

$app->run();
