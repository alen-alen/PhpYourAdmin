<?php

namespace PhpYourAdimn\App\Auth;

use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\Core\Database\Query;

class UserAuth
{
    public Cookie $cookie;
    public Route $route;
    public UserFile $userFile;
    public Query $query;

    public function __construct(
        Cookie $cookie,
        Route $route,
        UserFile $userFile,
        Query $query
    ) {
        $this->cookie = $cookie;
        $this->route = $route;
        $this->userFile = $userFile;
        $this->query = $query;
    }
    /**
     * Check if there is a user loged in if not redirects to login page
     */
    public function autorize()
    {
        if (!$this->cookie->has('user')) {
            $this->route->redirect('login');
        }
    }

    /**
     * Check if the Mysqluser  has grant privileges
     */
    public function isAdmin()
    {
        $users = $this->query->getMysqlUsers();

        $logedUser = $this->userFile->getUserById($this->cookie->get('user'));

        $logedUser = array_filter($users, function ($user) use ($logedUser) {
            return $logedUser['username'] === $user['User'] && $logedUser['host'] === $user['Host'];
        });

        if ($logedUser[0]['Grant_priv'] !== "Y") {
            $this->route->redirect('database/users');
        }
    }
}
