<?php

namespace PhpYourAdimn\Core;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\App\Helpers\Session;
use PhpYourAdimn\Core\Database\Connection;

class App
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function run()
    {
        if (Cookie::isSet('user')) {
            Connection::make();
        }

        $this->router->load('app/routes.php')
            ->direct(Request::uri(), Request::method());
    }

    public static function redirect($path, array $data = null)
    {
        if ($data == null) {
            header("Location:/{$path}");
            die();
        }
        Session::set($data[0], $data[1]);
        header("Location:/{$path}");
        die();
    }
  public static  function dd($data)
{
    echo "<pre>";
    die(var_dump($data));
    echo "</pre>";
}
}
