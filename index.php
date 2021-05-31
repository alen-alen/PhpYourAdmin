<?php

use Monolog\Logger;
use DI\ContainerBuilder;
use PhpYourAdimn\Core\App;
use PhpYourAdimn\Core\Router;
use PhpYourAdimn\Core\Env\DotEnv;
use Monolog\Handler\StreamHandler;

require __DIR__ . '/vendor/autoload.php';

die(var_dump(phpinfo()));
(new DotEnv(__DIR__ . '/.env'))->load();

$builder = new ContainerBuilder();

$builder->addDefinitions(__DIR__ . './core/config.php');

$container = $builder->build();

$session = $container->get('PhpYourAdimn\App\Helpers\Session');

$session->start();

$app = $container->get('PhpYourAdimn\Core\App');

$app->run();

$session->destroy();
