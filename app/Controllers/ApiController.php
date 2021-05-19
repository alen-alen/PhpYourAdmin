<?php

namespace PhpYourAdimn\App\Controllers;

class ApiController extends Controller
{
    public function dashboard()
    {
        $databases = $this->query->getDatabases();
        $tables = $this->query->allTables();
        // $data = [];
        // foreach ($databases as $database) {
        //     $tmpTables = [];
        //     foreach ($tables as $table) {
        //         if ($table->TABLE_SCHEMA === $database) {
        //             $tmpTables[] = $table->TABLE_NAME;
        //         }
        //     }
        //     $data[] = ['database' => $database, 'tables' => $tmpTables];
        // }
        $data = json_encode($databases);
        print_r($data);
    }
    public function getTables($request)
    {
        $tables = $this->query->getTables($request['db']);
        $data = json_encode($tables);
        print_r($data);
    }
}
