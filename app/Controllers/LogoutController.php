<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\Core\Log\FileLogger;

class LogoutController extends Controller
{
    /**
     * @var UserFile $userFile
     */
    private UserFile $userFile;

    /**
     * Translate constructor.
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
        $this->userAuth->autorize();
        $this->userFile = $userFile;
    }
    /**
     * Delete the user from the txt file and
     * destroy the user cookie
     * 
     * @return void
     */
    public function logout(): void
    {
        $this->userFile->deleteUser($this->request->cookie->get('user'));

        $this->request->cookie->destroy('user');

        $this->route->redirectHome();
    }
}
