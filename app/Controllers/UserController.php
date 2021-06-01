<?php

namespace PhpYourAdmin\App\Controllers;

use PhpYourAdmin\Core\Request;
use PhpYourAdmin\App\Auth\UserAuth;
use PhpYourAdmin\App\Exceptions\RequestException;
use PhpYourAdmin\App\Helpers\Route;
use PhpYourAdmin\Core\Database\Query;
use PhpYourAdmin\Core\Log\FileLogger;
use PhpYourAdmin\App\Models\MysqlUser;
use PhpYourAdmin\App\Requests\MysqlUserRequest;

class UserController extends Controller
{
    /**
     * Translate contructor.
     * @param Route $route
     * @param Query $query
     * @param UserAuth $userAuth
     * @param Request $request
     */
    public function __construct(
        Query $query,
        Request $request,
        Route $route,
        UserAuth $userAuth,
        FileLogger $logger
    ) {
        parent::__construct($query, $request, $route, $userAuth, $logger);

        $this->userAuth->autorize();
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
        $this->userAuth->checkAdmin();

        return $this->view('user/create');
    }

    /**
     * Create the new Mysql user
     * 
     */
    public function store()
    {
        $this->userAuth->checkAdmin();

        $mysqlUserRequest = new MysqlUserRequest($this->request->requestData(), $this->query->getMysqlUsers());

        try {
            $inputs = $mysqlUserRequest->validate();
        } catch (RequestException $e) {
            $this->route->redirect('database/users/create', ['error', $e->getMessage()]);
        }

        $user = new MysqlUser($inputs['username'], $inputs['host'], $inputs['type'], $inputs['password']);

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
        $this->userAuth->checkAdmin();

        $users = $this->query->getMysqlUsers();

        if (key_exists($this->request->parameter('id'), $users)) {
            $user = $users[$this->request->parameter('id')];
            $this->query->deleteSqlUser($user['User'], $user['Host']);
        }
        $this->route->redirect('database/users', ['success', "sucessfuly deleted user {$user['User']}@{$user['Host']}"]);
    }
}
