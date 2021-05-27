<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\Core\Traits\Auth;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\App\Models\MysqlUser;
use PhpYourAdimn\App\Requests\MysqlUserRequest;

class UserController extends Controller
{
    public function __construct(Query $query, Request $request, Route $route)
    {
        $this->autorize();
        
        parent::__construct($query, $request, $route);
    }

    /**
     * Show all available users
     */
    public function index()
    {
        $users = $this->query->getMysqlUsers();

        return $this->view('user/index', compact('users'));
    }

    /**
     * Show the create user form
     */
    public function create()
    {
        // UserAuth::isAdmin();

        return $this->view('user/create');
    }

    /**
     * Create the new Mysql user
     * 
     */
    public function store()
    {
        // UserAuth::isAdmin();

        $MysqlUserRequest = new MysqlUserRequest($this->request->postParameters(), $this->query->getMysqlUsers(), $this->route);

        $inputs = $MysqlUserRequest->validate();

        $user = new MysqlUser($inputs['username'], $inputs['host'], $inputs['password'], $inputs['type']);

        $this->query->createSqlUser($user);
        $this->query->setUserPrivileges($user);

        $this->route->redirect('database/users');
    }

    /**
     * Delete the selected user
     * 
     */
    public function delete()
    {
        // UserAuth::isAdmin();

        $users = $this->query->getMysqlUsers();

        if (key_exists($this->request->getParameter('id'), $users)) {
            $user = $users[$this->request->getParameter('id')];
            $this->query->deleteSqlUser($user['User'], $user['Host']);
        }
        $this->route->redirect('database/users', ['success', "sucessfuly deleted user {$user['User']}@{$user['Host']}"]);
    }
}
