<?php

namespace PhpYourAdimn\App\Auth;

use PhpYourAdimn\Core\App;
use PhpYourAdimn\App\Helpers\Cookie;

class UserAuth
{
    /**
     * Check if there is a user loged in if not redirects to login page
     */
    public static function autorize()
    {
        if (!Cookie::isSet('user')) {
            App::redirect('login');
        }
    }
}
