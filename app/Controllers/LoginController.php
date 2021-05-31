<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Models\User;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\Core\Log\FileLogger;
use PhpYourAdimn\App\Requests\LoginRequest;
use PhpYourAdimn\App\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * @var UserFile $userFile
     */
    public UserFile $userFile;

    /**
     * @param Route $route
     * @param Query $query
     * @param UserAuth $userAuth
     * @param Request $request
     * @param UserFile $userFile
     */
    public function __construct(
        Query $query,
        Request $request,
        Route $route,
        UserFile $userFile,
        UserAuth $userAuth,
        FileLogger $logger
    ) {
        parent::__construct($query, $request, $route, $userAuth, $logger);
        $this->userFile = $userFile;
    }

    /**
     * Show the login form
     */
    public function index()
    {
        return $this->view('login');
    }

    /**
     * Saves the user in a txt file and creates a connection with mysql
     */
    public function login()
    {
        $loginRequest = new LoginRequest($this->query, $this->request->requestData(), $this->route, $this->logger);

        $request = $loginRequest->validate();

        $user = new User();

        $this->userFile->saveUser($request['host'], $request['username'], $request['password'], $user->getId());

        $this->request->cookie->set('user', time());

        $this->route->redirect('database/dashboard');
    }
}
