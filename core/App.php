<?php

namespace PhpYourAdimn\Core;

use Exception;
use PhpYourAdimn\Core\Request;
use PhpYourAdimn\Core\Log\FileLogger;

class App
{
    /**
     * Instance of the Router class
     * @var Router $router
     */
    private $router;

    public function __construct(Router $router, FileLogger $logger)
    {
        $this->logger = $logger;
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
            $this->logger->error($e->getMessage());
            $this->router->container->get('PhpYourAdimn\\App\\Helpers\\Route')->redirectHome();
        }
    }

    public function __destruct()
    {
        $this->router->container->get('PhpYourAdimn\\Core\\Database\\Connection')->close();
    }
}
