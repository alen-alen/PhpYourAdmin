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
        $data = json_encode($databases);
        return print_r($data);
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
        $data = json_encode($tables);
        return print_r($data);
    }
}
