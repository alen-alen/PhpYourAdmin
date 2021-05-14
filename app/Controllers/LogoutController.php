<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Cookie;

class LogoutController extends Controller
{
    /**
     * Delete the user from the txt file and
     * destroy the user cookie
     * 
     * @return void
     */
    public function logout(): void
    {
        UserFile::deleteUser(Cookie::get('user'));

        Cookie::destroy('user');

        Route::redirect('');
    }
}
