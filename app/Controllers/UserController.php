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
    public function __construct(Query $query)
    {
        parent::__construct($query);

        UserAuth::autorize();
    }
    public function index()
    {
        $users = $this->query->getMysqlUsers();

        return $this->view('user/index', compact('users'));
    }

    public function create()
    {
        return $this->view('user/create');
    }

    public function store($request)
    {
        $MysqlUserRequest = new MysqlUserRequest($request->postParameters(), $this->query->getMysqlUsers());

        $inputs = $MysqlUserRequest->validate();

        $user = new MysqlUser($inputs['username'], $inputs['host'], $inputs['password'], $inputs['type']);

        $this->query->createSqlUser($user);
        $this->query->setUserPrivileges($user);

        Route::redirect('database/users');
    }

    public function delete(Request $request)
    {
        $users = $this->query->getMysqlUsers();

        if (key_exists($request->getParameter('id'), $users)) {
            $user = $users[$request->getParameter('id')];
            $this->query->deleteSqlUser($user['User'], $user['Host']);
        }
        Route::redirect('database/users', ['success', "sucessfuly deleted user {$user['User']}@{$user['Host']}"]);
    }
}
