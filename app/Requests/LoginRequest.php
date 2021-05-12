<?php

namespace PhpYourAdimn\App\Requests;

use PhpYourAdimn\Core\App;
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
        
            if (Connection::validate($this->data['host'], $this->data['username'], $this->data['password'])) {
                return $this->data;
            }
            App::redirect('login', ['error', 'Invalid Credentials']);
        }
        App::redirect('login', ['error', 'Inputs cannot be empty']);
    }
}
