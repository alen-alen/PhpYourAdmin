<?php

namespace PhpYourAdimn\App\Controllers;

class ApiController extends Controller
{
    public function dashboard()
    {
        $databases = $this->query->getDatabases();
        $data = json_encode($databases);
        print_r($data);
    }
    public function getTables($request)
    {
        $tables = $this->query->getTables($request->getParameter('db'));
        $data = json_encode($tables);
        print_r($data);
    }
}
