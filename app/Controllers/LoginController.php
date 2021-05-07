<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\App;
use PhpYourAdimn\App\Models\User;
use PhpYourAdimn\App\Helpers\File;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\App\Requests\LoginRequest;

class LoginController extends Controller
{
    public function index()
    {
      
        return $this->view('login');
    }

    public function login()
    {
        $request = $_POST;

        $loginRequest = new LoginRequest($request);

        $request = $loginRequest->validate();

        $user = new User();

        File::saveUser($request['host'], $request['username'], $request['password'], $user->getId());

        Cookie::set('user', time());

        App::redirect('home');
    }
}
