<?php

namespace PhpYourAdmin\App\Models;

class User
{
    /**
     * User id
     * 
     * @var string $id
     */
    private string $id;

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
