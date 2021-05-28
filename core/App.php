<?php

namespace PhpYourAdimn\Core;

use Exception;
use PhpYourAdimn\Core\Request;

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
        }
    }

    public function __destruct()
    {
        $this->router->container->get('PhpYourAdimn\\Core\\Database\\Connection')->close();
    }
}
