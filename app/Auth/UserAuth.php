<?php

namespace PhpYourAdimn\App\Auth;

use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Cookie;

class UserAuth
{
    /**
     * Check if there is a user loged in if not redirects to login page
     */
    public static function autorize()
    {
        if (!Cookie::exist('user')) {
            Route::redirect('login');
        }
    }
}
