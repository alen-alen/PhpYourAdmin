<?php

use DI\ContainerBuilder;
use PhpYourAdmin\App\Helpers\Session;
use PhpYourAdmin\Core\Env\DotEnv;

require __DIR__ . '/vendor/autoload.php';

(new DotEnv(__DIR__ . '/.env'))->load();

$builder = new ContainerBuilder();

$builder->addDefinitions(__DIR__ . './core/config.php');

$container = $builder->build();

$session = $container->get(Session::class);

$session->start();

$app = $container->get('PhpYourAdmin\Core\App');

$app->run();

$session->destroy();
