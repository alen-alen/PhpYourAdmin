<?php

namespace PhpYourAdimn\App\Controllers;


use PhpYourAdimn\Core\App;

use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\App\Helpers\UserFile;
use PhpYourAdimn\Core\Database\Connection;


class LogoutController extends Controller
{
    public function logout()
    {
        UserFile::deleteUser($_COOKIE['user']);

        Connection::disconect();

        Cookie::destroy('user');

        App::redirect('');
    }
}
