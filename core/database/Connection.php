<?php

namespace PhpYourAdimn\Core\Database;

use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Cookie;

class Connection
{
    /**
     * @var PDO $connection
     */
    public static $pdo = NULL;

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

    private function __construct()
    {
        $this->config = UserFile::getUserById(Cookie::get('user'));

        if (isset($_GET['db'])) {
            return $this->connectDb($_GET['db']);
        }
        return  $this->createConnection();
    }

    /**
     * Creates a connection with the logged in user's credentials
     * 
     * @return void
     */
    private function createConnection(): void
    {
        try {
            self::$pdo = new \PDO("mysql:host={$this->config['host']}", $this->config['username'], $this->config['password']);
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
    private function connectDb(string $dbName): void
    {
        try {
            self::$pdo = new \PDO("mysql:host={$this->config['host']};dbname={$dbName}", $this->config['username'], $this->config['password']);
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
        if (self::$instance === NULL) {
            self::$instance = new Connection();
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
        return self::$pdo;
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
    public static function validate(string $host, string $username, string $password): bool
    {
        if (self::$pdo === null) {
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
    public static function close(): void
    {
        if (self::$pdo !== null) {
            self::$pdo = null;
        }
    }
}
