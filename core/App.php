<?php

namespace PhpYourAdimn\Core;

use Exception;
use DI\ContainerBuilder;
use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Connection;

class App
{
    /**
     * Instance of the Router class
     * @var Router $router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    /**
     * Start The Application
     */
    public function run()
    {
        try {
            $this->router->load('app/routes.php')
                ->direct(Request::uri(), Request::method());
        } catch (Exception $e) {
            die($e->getMessage());
            // Route::redirect('database/dashboard');
        }
    }

    public function __destruct()
    {
        // Connection::close();
    }
}
