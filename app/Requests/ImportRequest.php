<?php

namespace PhpYourAdmin\App\Requests;

use PhpYourAdmin\App\Exceptions\RequestException;
use PhpYourAdmin\App\Helpers\Route;

class ImportRequest
{
    /**
     * Data from the form request 
     * 
     * @var array $data
     */
    private $data;

    /**
     * @param array $userInputs
     */
    public function __construct(array $userInputs)
    {
        $this->data = $userInputs;
    }

    /**
     * On error rthrow RequestException,
     * else return the request data.
     */
    public function validate()
    {
        if (empty($this->data['name'])) {
            throw new RequestException('Must select a file');
        }
        $fileName = explode('.', $this->data['name']);
        if (end($fileName) !== 'sql') {
            throw new RequestException('File must be of type sql!');
        }
        return $this->data;
    }
}
