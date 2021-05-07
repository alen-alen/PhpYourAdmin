<?php

namespace PhpYourAdimn\App\Controllers;

class Controller
{
    public function view($name, array $data = [])
    {
        extract($data);

        return require "app/views/${name}.view.php";
    }
}
