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

    /**
     * @param array $userInputs
     */
    public function __construct(array $userInputs)
    {
        $this->data = $userInputs;
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
            Route::redirect('database/import', ['error', $this->messages]);
        }
        return $this->data;
    }
}
