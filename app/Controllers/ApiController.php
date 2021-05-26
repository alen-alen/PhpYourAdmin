<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\Core\Request;

class ApiController extends Controller
{
    public function __construct(Query $query)
    {
        parent::__construct($query);
    }
    /**
     * Api route for databases
     * 
     * @return array $data 
     */
    public function databases()
    {
        $databases = $this->query->getDatabases();
        echo json_encode($databases);
    }

    /**
     * Api route for database tables
     * 
     * @param Request $request
     * @return array $data 
     */
    public function getTables(Request $request)
    {
        $tables = $this->query->getDatabaseTables($request->getParameter('db'));
        echo json_encode($tables);
    }
}
