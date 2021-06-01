<?php

namespace PhpYourAdmin\App\Controllers;

use PhpYourAdmin\Core\Request;
use PhpYourAdmin\App\Models\User;
use PhpYourAdmin\App\Auth\UserAuth;
use PhpYourAdmin\App\File\UserFile;
use PhpYourAdmin\App\Helpers\Route;
use PhpYourAdmin\Core\Database\Query;
use PhpYourAdmin\Core\Log\FileLogger;
use PhpYourAdmin\App\Requests\LoginRequest;
use PhpYourAdmin\App\Controllers\Controller;
use PhpYourAdmin\App\Exceptions\RequestException;

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
    public function login(): void
    {
        $loginRequest = new LoginRequest($this->query, $this->request->requestData());
        try {
            $request = $loginRequest->validate();
        } catch (RequestException $e) {
            $this->logger->info($e->getMessage());
            $this->route->redirect('login', ['error', [$e->getMessage()]]);
        }

        $user = new User();

        $this->userFile->saveUser($request['host'], $request['username'], $request['password'], $user->getId());

        $this->request->cookie->set('user', time());

        $this->route->redirect('database/dashboard');
    }
}
