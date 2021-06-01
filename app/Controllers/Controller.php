<?php

namespace PhpYourAdmin\App\Controllers;

use PhpYourAdmin\Core\Request;
use PhpYourAdmin\App\Auth\UserAuth;
use PhpYourAdmin\App\Helpers\Route;
use PhpYourAdmin\Core\Database\Query;
use PhpYourAdmin\Core\Log\FileLogger;

class Controller
{
    /**
     * @var Query $query
     */
    protected Query $query;

    /**
     * @var Request $request
     */
    protected Request $request;

    /**
     * @var Route $route
     */
    protected Route $route;

    /**
     * @var UserAuth $userAuth
     */
    protected UserAuth $userAuth;

    /**
     * @var FileLogger $logger
     */
    protected FileLogger $logger;

    /**
     * Translate constructor.
     * 
     * @param Query $query
     * @param Request $request
     * @param Route $route
     * @param UserAuth $userAuth
     * @param FileLogger
     */
    public function __construct(
        Query $query = null,
        Request $request,
        Route $route,
        UserAuth $userAuth,
        FileLogger $logger
    ) {
        $this->userAuth = $userAuth;
        $this->query = $query;
        $this->route = $route;
        $this->request = $request;
        $this->logger = $logger;
    }

    /**
     * Get the evaluated view contents for the given view,always extract Request instance
     * 
     * @param string $name file path in the view directory
     * @param array $data data that is sent to the view
     */
    protected function view($name, array $data = [])
    {
        $request = $this->request;
        extract($data);
        extract(['request' => $request]);
        return require "app/views/${name}.view.php";
    }
}
