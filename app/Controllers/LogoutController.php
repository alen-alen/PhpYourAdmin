<?php

namespace PhpYourAdimn\App\Controllers;


use PhpYourAdimn\Core\App;
use PhpYourAdimn\App\Helpers\File;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\Core\Database\Connection;


class LogoutController extends Controller
{
    public function logout()
    {
        File::deleteUser($_COOKIE['user']);

        Connection::disconect();

        Cookie::destroy('user');

        App::redirect('/');
    }
}
