<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\Core\Database\Query;

class LogoutController extends Controller
{
    public UserFile $userFile;

    public function __construct(Query $query, Request $request, Route $route,UserFile $userFile)
    {
        $this->userFile = $userFile;
        parent::__construct($query, $request,$route);
       
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
