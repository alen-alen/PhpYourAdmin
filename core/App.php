<?php

namespace PhpYourAdimn\Core;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\App\Helpers\Session;
use PhpYourAdimn\Core\Database\Connection;

class App
{
    /**
     * Instance of the Router class
     * @var Router $router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    /**
     * Start The Application
     */
    public function run()
    {
        UserFile::createFile(getenv('FILE_PATH'));

        if (Cookie::exist('user')) {
            Connection::getInstance();
        }

        $this->router->load('app/routes.php')
            ->direct(Request::uri(), Request::method());
    }
    /**
     * 
     */
    public static function redirect($path, array $data = null)
    {
        if (!$data) {
            header("Location:/{$path}");
            die();
        }
        Session::set($data[0], $data[1]);
        header("Location:/{$path}");
        die();
    }

    public function __destruct()
    {
        Connection::close();
    }
}
