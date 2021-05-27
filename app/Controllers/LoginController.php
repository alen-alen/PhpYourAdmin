<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Models\User;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\Core\Database\Connection;
use PhpYourAdimn\App\Requests\LoginRequest;
use PhpYourAdimn\Core\Database\Query;

class LoginController extends Controller
{

    public function __construct(Query $query, Request $request, Route $route, UserFile $userFile)
    {
        $this->userFile = $userFile;
        parent::__construct($query, $request, $route);
    }
    public function index()
    {
        return $this->view('login');
    }

    /**
     * Saves the user in a txt file and creates a connection with mysql
     */
    public function login()
    {
        $loginRequest = new LoginRequest($this->query, $this->request->postParameters(), $this->route);

        $request = $loginRequest->validate();

        $user = new User();

        $this->userFile->saveUser($request['host'], $request['username'], $request['password'], $user->getId());

        $this->request->cookie->set('user', time());

        $this->route->redirect('database/dashboard');
    }
}
