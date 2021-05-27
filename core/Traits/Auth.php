<?php

namespace PhpYourAdimn\Core\Traits;

trait Auth
{
    public function autorize()
    {
        if (!isset($_COOKIE['user'])) {
            header('Location:/login');
        }
    }
}
