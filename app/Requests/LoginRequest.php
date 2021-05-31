<?php

namespace PhpYourAdimn\App\Requests;

use Exception;
use PDOException;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\Core\Database\Query;
use PhpYourAdimn\Core\Log\FileLogger;
use PhpYourAdimn\Core\Exceptions\ServerException;

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

    /**
     * Query $query
     */
    private Query $query;

    /**
     * Route $route
     */
    private Route $route;

    private FileLogger $logger;

    /**
     * @param array $userInputs
     * @param Route $route
     * @param Query $query
     */
    public function __construct(Query $query, array $userInputs, Route $route, FileLogger $logger)
    {
        $this->query = $query;
        $this->data = $userInputs;
        $this->route = $route;
        $this->logger = $logger;
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
            try {
                $this->query->validateConnection($this->data['host'], $this->data['username'], $this->data['password']);
                return $this->data;
            } catch (PDOException $e) {
                $this->logger->error($e->getMessage());
                $this->messages['connection'] = $e->getMessage();
                $this->route->redirect('login', ['error', $this->messages]);
            }
        }
        $this->route->redirect('login', ['error', $this->messages]);
    }
}
