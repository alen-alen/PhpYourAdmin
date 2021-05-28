<?php

use DI\ContainerBuilder;
use PhpYourAdimn\Core\App;
use PhpYourAdimn\Core\Router;
use PhpYourAdimn\Core\Env\DotEnv;

require __DIR__ . '/vendor/autoload.php';

(new DotEnv(__DIR__ . '/.env'))->load();

$builder = new ContainerBuilder();

$builder->addDefinitions(__DIR__ . './core/config.php');

$container = $builder->build();

$session = $container->get('PhpYourAdimn\App\Helpers\Session');

$session->start();

$app = new App(new Router($container));

$app->run();

$session->destroy();
