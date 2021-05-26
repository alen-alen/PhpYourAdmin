<?php

namespace PhpYourAdimn\App\Auth;

use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\Core\Database\Connection;

class UserAuth
{
    public function __construct()
    {
    }
    /**
     * Check if there is a user loged in if not redirects to login page
     */
    public static function autorize()
    {
        if (!Cookie::has('user')) {
            Route::redirect('login');
        }
    }

    /**
     * Check if the Mysqluser  has grant privileges
     */
    // public static function isAdmin()
    // {
    //     $query = new Query(Connection::getInstance()->getConnection());

    //     $users = $query->getMysqlUsers();

    //     $logedUser = UserFile::getUserById(Cookie::get('user'));

    //     $logedUser = array_filter($users, function ($user) use ($logedUser) {
    //         return $logedUser['username'] === $user['User'] && $logedUser['host'] === $user['Host'];
    //     });

    //     if ($logedUser[0]['Grant_priv'] !== "Y") {
    //         Route::redirect('database/users');
    //     }
    // }
}
