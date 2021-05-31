<?php

namespace PhpYourAdimn\App\Controllers;

class ApiController extends Controller
{
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
