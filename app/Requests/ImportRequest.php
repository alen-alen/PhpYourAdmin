<?php

namespace PhpYourAdimn\App\Requests;

use PhpYourAdimn\App\Helpers\Route;

class ImportRequest
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
     * @param Route $route
     * @param array $userInputs
     */
    public function __construct(array $userInputs,Route $route)
    {
        $this->data = $userInputs;
        $this->route=$route;
    }
    /**
     * On error redirect back with error messages,
     * else return the request.
     */
    public function validate()
    {
        $fileName = explode('.', $this->data['name']);

        if (end($fileName) !== 'sql') {
            $this->messages['file'] = 'File must be of type sql!';
            $this->error = true;
        }
        if ($this->error) {
            $this->route->redirect('database/import', ['error', $this->messages['file']]);
        }
        return $this->data;
    }
}
