<?php

namespace PhpYourAdmin\Core;

use Exception;
use PhpYourAdmin\Core\Request;
use PhpYourAdmin\App\Helpers\Route;
use PhpYourAdmin\Core\Log\FileLogger;

class App
{
    /**
     * Instance of the Router class
     * @var Router $router
     */
    private Router $router;

    /**
     * @var FileLogger $logger
     */
    private FileLogger $logger;

    /**
     * @param Router $router 
     * @param FileLogger $logger
     */
    public function __construct(Router $router, FileLogger $logger)
    {
        $this->logger = $logger;
        $this->router = $router;
    }

    /**
     * Start The Application
     */
    public function run(): void
    {
        try {
            $this->router->load('app/routes.php')
                ->direct(Request::uri(), Request::method());
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            ($this->router->container->get(Route::class))->redirectHome();
        }
    }

    /**
     * Close the mysql connection
     */
    public function __destruct()
    {
        $this->router->container->get('PhpYourAdmin\\Core\\Database\\Connection')->close();
    }
}
