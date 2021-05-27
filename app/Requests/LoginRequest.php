<?php

namespace PhpYourAdimn\App\Requests;

use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\Core\Database\Connection;

class LoginRequest
{
    /**
     * Data from the form request 
     * 
     * @var array $data
     */
    private $data;
    /**
     * @var array $messages
     */
    private $messages;

    /**
     * flag if there are errors
     * 
     * @var bool $error
     */
    private $error = false;

    private Query $query;

    /**
     * @param array $userInputs
     */
    public function __construct(Query $query, array $userInputs,Route $route)
    {
        $this->query = $query;
        $this->data = $userInputs;
    }
    /**
     * On error redirect back with error messages,
     * else return the request.
     */
    public function validate()
    {
        if (!isset($this->data['username']) || empty($this->data['username'])) {
            $this->messages['username'] = 'Username field cannot be empty';
            $this->error = true;
        }
        if (!isset($this->data['host']) || empty($this->data['host'])) {
            $this->messages['host'] = 'Host field cannot be empty';
            $this->error = true;
        }
        if (!isset($this->data['password']) || empty($this->data['password'])) {
            $this->data['password'] = '';
        }

        if (!$this->error) {
            if ($this->query->validateConnection($this->data['host'], $this->data['username'], $this->data['password'])) {
                return $this->data;
            }
            $this->route->redirect('login', ['error', 'Invalid Credentials']);
        }
        $this->route->redirect('login', ['error', 'Inputs cannot be empty']);
    }
}
