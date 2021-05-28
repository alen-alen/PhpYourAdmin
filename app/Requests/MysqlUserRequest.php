<?php

namespace PhpYourAdimn\App\Requests;

use PhpYourAdimn\App\Helpers\Route;

class MysqlUserRequest
{
    /**
     * Data from the form request 
     * 
     * @var array $data
     */
    private $data;

    /**
     * Data from the form request 
     * 
     * @var array $data
     */
    private array $existingUsers;

    /**
     * @var array $messages
     */
    private $messages = [];

    /**
     * flag if there are errors
     * 
     * @var bool $error
     */
    private $error = false;

    private Route $route;

    /**
     * @param array $userInputs
     * @param array $existingUser
     */
    public function __construct(array $userInputs, array $existingUsers, Route $route)
    {
        $this->route = $route;
        $this->existingUsers = $existingUsers;

        $this->data = array_map(function ($input) {
            return trim($input);
        }, $userInputs);
    }
    /**
     * On error redirect back with error messages,
     * else return the request.
     */
    public function validate()
    {
        if (!isset($this->data['username']) && empty($this->data['username'])) {
            $this->messages['username'] = 'Username cannot be empty!';
            $this->error = true;
        }
        if (empty($this->data['host'])) {
            $this->messages['host'] = 'Host cannot be empty!';
            $this->error = true;
        }

        if ($this->userExists()) {
            $this->messages['user'] = 'User already exists !';
            $this->error = true;
        }

        if (empty($this->data['type'])) {
            $this->messages['type'] = 'User type cannot be empty!';
            $this->error = true;
        }
        if ($this->error) {
            $this->route->redirect('database/users/create', ['error', $this->messages]);
        }
        return $this->data;
    }
    /**
     * Check if the user already exists
     * @return bool
     */
    public function userExists(): bool
    {
        $username = $this->data['username'];
        $host = $this->data['host'];
        $userExists = array_filter($this->existingUsers, function ($existingUser) use ($username, $host) {
            return $existingUser['User'] === $username && $existingUser['Host'] === $host;
        });

        return !empty($userExists);
    }
}
