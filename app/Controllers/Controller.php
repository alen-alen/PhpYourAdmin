<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;

class Controller
{
    public Query $query;

    public Request $request;

    public Route $route;

    public UserAuth $userAuth;

    /**
     * @param Query $query
     * @param Request $request
     */
    public function __construct(
        Query $query = null,
        Request $request,
        Route $route,
        UserAuth $userAuth
    ) {
        $this->userAuth = $userAuth;
        $this->query = $query;
        $this->route = $route;
        $this->request = $request;
    }

    /**
     * Get the evaluated view contents for the given view,always extract Request instance
     * 
     * @param string $name file path in the view directory
     * @param array $data data that is sent to the view
     */
    public function view($name, array $data = [])
    {
        $request = $this->request;
        extract($data);
        extract(['request' => $request]);
        return require "app/views/${name}.view.php";
    }
}
