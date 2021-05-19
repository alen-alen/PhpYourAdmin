<?php

namespace PhpYourAdimn\Core;

use PhpYourAdimn\Core\Request;
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
        $this->router->load('app/routes.php')
            ->direct(Request::uri(), Request::method());
    }
  
    public function __destruct()
    {
        Connection::close();
    }
}
