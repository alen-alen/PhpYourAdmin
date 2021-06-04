<?php

namespace PhpYourAdmin\App\Requests;

use PDOException;
use PhpYourAdmin\App\Exceptions\RequestException;
use PhpYourAdmin\Core\Database\Query;

class LoginRequest
{
    /**
     * Data from the form request 
     * 
     * @var array $data
     */
    private array $data;

    /**
     * Query $query
     */
    private Query $query;

    /**
     * @param array $userInputs
     * @param Query $query
     */
    public function __construct(Query $query, array $userInputs)
    {
        $this->query = $query;
        $this->data = $userInputs;
    }

    /**
     * On error throw RequestException,
     * else return the request data.
     */
    public function validate():array
    {
        if (!isset($this->data['username']) || empty($this->data['username'])) {
            throw new RequestException('Username field cannot be empty');
        }
        if (!isset($this->data['host']) || empty($this->data['host'])) {
            throw new RequestException('Host field cannot be empty');
        }
        if (!isset($this->data['password']) || empty($this->data['password'])) {
            $this->data['password'] = '';
        }

        try {
            $this->query->validateConnection($this->data['host'], $this->data['username'], $this->data['password']);
            return $this->data;
        } catch (PDOException $e) {
            throw new RequestException($e->getMessage());
        }
    }
}
