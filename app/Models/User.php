<?php

namespace PhpYourAdimn\App\Models;

use PhpYourAdimn\Core\Database\Connection;


class User
{
    private $id;

    public function __construct()
    {
        $this->id = time();
    }
    /**
     * Connects the user to the SQL server
     * 
     * @return void
     */
    public function connectToDb($credentials)
    {
        // Connection::connect($credentials['host'], $credentials['username'], $credentials['password']);
    }

    /**
     * Returns the id of the user.
     * @return int user id
     */
    public function getId()
    {
        return $this->id;
    }
}
