<?php

namespace PhpYourAdmin\App\Requests;

use PhpYourAdmin\App\Helpers\Route;
use PhpYourAdmin\App\Exceptions\RequestException;

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
     * @param array $userInputs
     * @param array $existingUser
     * @param Route $route
     */
    public function __construct(array $userInputs, array $existingUsers)
    {
        $this->existingUsers = $existingUsers;
        $this->data = $userInputs;
    }

    /**
     * On error throw RequestException,
     * else return the request data.
     */
    public function validate()
    {
        if (!isset($this->data['username']) || empty($this->data['username'])) {
            throw new RequestException('Username cannot be empty!');
        }
        if (!isset($this->data['host']) || empty($this->data['host'])) {
            throw new RequestException('Host cannot be empty!');
        }
        if ($this->userExists()) {
            throw new RequestException('User already exists !');
        }
        if (!isset($this->data['type']) || empty($this->data['type'])) {
            throw new RequestException('User type cannot be empty!');
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
