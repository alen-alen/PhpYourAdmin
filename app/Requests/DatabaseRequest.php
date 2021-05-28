<?php

namespace PhpYourAdimn\App\Requests;

use PhpYourAdimn\App\Helpers\Route;

class DatabaseRequest
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
    private $messages = [];

    /**
     * flag if there are errors
     * 
     * @var bool $error
     */
    private $error = false;

    public Route $route;

    /**
     * @param Route $route;
     * @param array $userInputs
     */
    public function __construct(array $userInputs, Route $route)
    {
        $this->route = $route;
        $this->data = $userInputs;
    }

    /**
     * On error redirect back with error messages,
     * else return the request.
     */
    public function validate($existingDatabases)
    {
        if (!isset($this->data['dbName']) || empty($this->data['dbName'])) {
            $this->messages['emptyField'] = 'Database name field cannot be empty';
            $this->error = true;
        } else {
            if (in_array($this->data['dbName'], $existingDatabases)) {
                $this->messages['dbName'] = 'Database already exists';
                $this->error = true;
            }
        }
        if (!isset($this->data['collationId']) || !is_numeric($this->data['collationId'])) {
            $this->messages['collation'] = 'Please select a collation';
            $this->error = true;
        }
        if (!is_numeric($this->data['collationId'])) {
            $this->messages['collation'] = 'Please select a valid collation';
            $this->error = true;
        }

        if ($this->error) {
            $this->route->redirect('database/create', ['error', $this->messages]);
        }
        return $this->data;
    }
}
