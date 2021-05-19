<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\Core\Request;

class Controller
{
    public $query;

    /**
     * @param Query $query
     */
    public function __construct(Query $query = null)
    {
        $this->query = $query;
    }

    /**
     * Get the evaluated view contents for the given view.
     * 
     * @param string $name file path in the view directory
     * @param array $data data that is sent to the view
     */
    public function view($name, array $data = [])
    {
        $request = new Request();
        extract($data);
        extract(['request' => $request]);

        return require "app/views/${name}.view.php";
    }
}
