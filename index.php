<?php



use PhpYourAdimn\Core\App;
use PhpYourAdimn\Core\Router;
use PhpYourAdimn\Core\Env\DotEnv;



require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/core/helpers.php';

session_start();

(new DotEnv(__DIR__ . '/.env'))->load();

$app = new App(new Router());

$app->run();
