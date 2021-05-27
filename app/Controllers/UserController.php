<?php

namespace PhpYourAdimn\App\Controllers;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Auth\UserAuth;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Models\MysqlUser;
use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\App\Requests\MysqlUserRequest;

class UserController extends Controller
{
    public function __construct(Query $query, Request $request)
    {
        parent::__construct($query, $request);

        UserAuth::autorize();
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
     * @param Request $request
     */
    public function store(Request $request)
    {
        // UserAuth::isAdmin();

        $MysqlUserRequest = new MysqlUserRequest($request->postParameters(), $this->query->getMysqlUsers());

        $inputs = $MysqlUserRequest->validate();

        $user = new MysqlUser($inputs['username'], $inputs['host'], $inputs['password'], $inputs['type']);

        $this->query->createSqlUser($user);
        $this->query->setUserPrivileges($user);

        Route::redirect('database/users');
    }

    /**
     * Delete the selected user
     * 
     * @param Request $request
     */
    public function delete(Request $request)
    {
        // UserAuth::isAdmin();

        $users = $this->query->getMysqlUsers();

        if (key_exists($this->request->getParameter('id'), $users)) {
            $user = $users[$this->request->getParameter('id')];
            $this->query->deleteSqlUser($user['User'], $user['Host']);
        }
        Route::redirect('database/users', ['success', "sucessfuly deleted user {$user['User']}@{$user['Host']}"]);
    }
}
