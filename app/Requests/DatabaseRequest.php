<?php

namespace PhpYourAdmin\App\Requests;

use PhpYourAdmin\App\Exceptions\RequestException;

class DatabaseRequest
{
    /**
     * Data from the form request 
     * 
     * @var array $data
     */
    private array $data;

    /**
     * @param array $userInputs
     */
    public function __construct(array $userInputs)
    {
        $this->data = $userInputs;
    }

    /**
     * On error throw RequestException,
     * else return the request data.
     */
    public function validate(array $existingDatabases): array
    {
        if (!isset($this->data['dbName']) || empty($this->data['dbName'])) {
            throw new RequestException('Database name field cannot be empty');
        }
        if (in_array($this->data['dbName'], $existingDatabases)) {
            throw new RequestException('Database already exists');
        }
        if (!isset($this->data['collationId']) || !is_numeric($this->data['collationId'])) {
            throw new RequestException('Please select a collation');
        }
        if (!is_numeric($this->data['collationId'])) {
            throw new RequestException('Please select a valid collation');
        }

        return $this->data;
    }
}
