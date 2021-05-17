<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\App\Models\User;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\App\Requests\LoginRequest;


class LoginController extends Controller
{
    public function index()
    {
        return $this->view('login');
    }

    /**
     * Saves the user in a txt file and creates a connection with mysql
     * 
     * @param array $request
     */
    public function login($request)
    {
        $loginRequest = new LoginRequest($request);

        $request = $loginRequest->validate();

        $user = new User();

        UserFile::saveUser($request['host'], $request['username'], $request['password'], $user->getId());

        Cookie::set('user', time());

        Route::redirect('database/dashboard');
    }
}
