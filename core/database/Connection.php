<?php

namespace PhpYourAdimn\Core\Database;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Cookie;

class Connection
{
    /**
     * @var PDO $connection
     */
    public $pdo = NULL;

    /**
     * Instance of this class
     * 
     * @var Connection $instance
     */
    public static $instance = NULL;

    /**
     * Connection configuration data
     * 
     * @var array $config
     */
    private array $config = [];

    private function __construct($dbName = null)
    {
        if (UserFile::getUserById(Cookie::get('user'))) {
            $this->config = UserFile::getUserById(Cookie::get('user'));
            if ($dbName) {
                return $this->connectDb($dbName);
            }
            return  $this->createConnection();
        }
    }

    /**
     * Creates a connection with the logged in user's credentials
     * 
     * @return void
     */
    private function createConnection(): void
    {
        try {
            $this->pdo = new \PDO("mysql:host={$this->config['host']}", $this->config['username'], $this->config['password']);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Update the connection with the selected database
     * 
     * @param string $dbName
     * @return void
     */
    public function connectDb(string $dbName): void
    {
        try {
            $this->pdo = new \PDO("mysql:host={$this->config['host']};dbname={$dbName}", $this->config['username'], $this->config['password']);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Create an instance of this class and return it
     * 
     * @return Connection
     */
    public static function getInstance(): Connection
    {
        if (!self::$instance) {
            self::$instance = new Connection(Request::getDatabaseName());
        }

        return self::$instance;
    }
    /**
     * Return the PDO connection
     * 
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->pdo;
    }

    /**
     * Try to establish a connection to  mysql 
     * 
     * @param string $host
     * @param string $username
     * @param string $password
     * 
     * @return true -on success
     * @return false -on failure
     */
    public function validate(string $host, string $username, string $password): bool
    {
        if (!$this->pdo) {
            try {
                new \PDO("mysql:host=$host", $username, $password);
                return true;
            } catch (\PDOException $e) {
                return false;
            }
        }
    }

    /**
     * Close the PDO connection
     * 
     * @return void
     */
    public function close(): void
    {
        if ($this->pdo) {
            $this->pdo = null;
        }
    }
}
