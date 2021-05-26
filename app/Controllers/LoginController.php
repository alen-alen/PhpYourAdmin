<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Models\User;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\Core\Database\Connection;
use PhpYourAdimn\App\Requests\LoginRequest;

class LoginController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        return $this->view('login');
    }

    /**
     * Saves the user in a txt file and creates a connection with mysql
     * 
     * @param array $request
     */
    public function login(Request $request)
    {
        $loginRequest = new LoginRequest(Connection::getInstance(), $request->postParameters());

        $request = $loginRequest->validate();

        $user = new User();

        UserFile::saveUser($request['host'], $request['username'], $request['password'], $user->getId());

        Cookie::set('user', time());

        Route::redirect('database/dashboard');
    }
}
