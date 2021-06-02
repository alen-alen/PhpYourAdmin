<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\Core\Request;

use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;

class ApiController extends Controller
{
    /**
     * Translate constructor.
     * 
     * @param Query $query
     * @param Request $request
     * @param Route $route
     * @param UserAuth $userAuth
     */
    public function __construct(
        Query $query,
        Request $request,
        Route $route,
        UserAuth $userAuth
    ) {
        parent::__construct($query, $request, $route, $userAuth);
    }

    /**
     * Api route for databases
     * 
     * @return void  
     */
    public function databases()
    {
        $databases = $this->query->getDatabases();
        echo json_encode($databases);
    }

    /**
     * Api route for database tables
     * 
     * @return void  
     */
    public function getTables()
    {
        $tables = $this->query->getDatabaseTables($this->request->parameter('db'));
        echo json_encode($tables);
    }
}
