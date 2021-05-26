<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;

class ApiController extends Controller
{

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
