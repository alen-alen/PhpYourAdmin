<?php

namespace PhpYourAdimn\App\Models;

use PhpYourAdimn\Core\Database\Connection;


class User
{
    /**
     * User id
     * 
     * @var string $id
     */
    private $id;

    public function __construct()
    {
        $this->id = (string) time();
    }

    /**
     * Returns the id of the user.
     * @return string user id
     */
    public function getId(): string
    {
        return (string) $this->id;
    }
}
