<?php

namespace PhpYourAdmin\App\Controllers;

class ApiController extends Controller
{
    /**
     * Api route for databases
     * 
     * @return void  
     */
    public function databases(): void
    {
        $databases = $this->query->getDatabases();

        echo json_encode($databases);
    }

    /**
     * Api route for database tables
     * 
     * @return void  
     */
    public function getTables(): void
    {
        $tables = $this->query->getDatabaseTables($this->request->parameter('db'));
        echo json_encode($tables);
    }
}
