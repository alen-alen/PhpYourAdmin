<?php

namespace PhpYourAdimn\App\Models;

class MysqlUser
{
    /**
     * User username
     * 
     * @var string $username
     */
    public $username;

    /**
     * User host
     * 
     * @var string $host
     */
    public string $host;

    /**
     * User password
     * 
     * @var string $id
     */
    public string $password;

    /**
     * User type
     * 
     * @var string $type
     */
    public string $type;

    /**
     * User GRANT OPTION
     * 
     * @var string $grantOption
     */
    public $grantOption = null;

    /**
     * User privileges
     * 
     * @var array $priviliges
     */
    public $priviliges;

    /**
     * Create new user object
     * and set its privileges
     * 
     * @param string $username 
     * @param string $host 
     * @param string $password 
     * @param string $type 
     * 
     * @return void
     */
    public function __construct($username, $host, $type, $password = null)
    {
        $this->username = $username;
        $this->host = $host;
        $this->password = $password;
        $this->type = $type;

        $this->setPriviliges();
    }

    /**
     * Sets the privilege propery based on the user type
     * @return void
     */
    public function setPriviliges()
    {
        switch ($this->type) {
            case 'user':
                $this->privileges[] = 'SELECT';
                break;
            case 'admin':
                $this->privileges[] = 'ALL PRIVILEGES';
                break;
            case 'adminGrant':
                $this->privileges[] = 'ALL';
                $this->grantOption = 'WITH GRANT OPTION';
                break;
            default:
                $this->privileges[] = 'SELECT';
        }
    }
}
