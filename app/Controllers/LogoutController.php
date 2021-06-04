<?php

namespace PhpYourAdmin\App\Controllers;

use PhpYourAdmin\Core\Request;
use PhpYourAdmin\App\Auth\UserAuth;
use PhpYourAdmin\App\File\UserFile;
use PhpYourAdmin\App\Helpers\Route;
use PhpYourAdmin\Core\Database\Query;
use PhpYourAdmin\Core\Log\FileLogger;

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
