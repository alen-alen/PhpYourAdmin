<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;

class ApiController extends Controller
{
    public function __construct(Query $query,Request $request,Route $route)
    {
        parent::__construct($query,$request,$route);
    }
    /**
     * Api route for databases
     * 
     * @return array $data 
     */
    public function databases()
    {
        $databases = $this->query->getParameterbases();
        echo json_encode($databases);
    }

    /**
     * Api route for database tables
     * 
     * @return array $data 
     */
    public function getTables()
    {
        $tables = $this->query->getParameterbaseTables($this->request->getParameter('db'));
        echo json_encode($tables);
    }
}
