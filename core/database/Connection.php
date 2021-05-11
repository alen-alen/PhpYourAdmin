<?php

namespace PhpYourAdimn\Core\Database;

use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\App\Helpers\Cookie;


class Connection
{
    /**
     * @var PDO $connection
     */
    public static $connection = NULL;

    /**
     * Instance of this class
     * 
     * @var Connection $instance
     */
    public static $instance = NULL;

    private function __construct()
    {
        $this->createConnection();
    }

    /**
     * Creates a connection with the logged in user's credentials
     * 
     * @return void
     */
    private function createConnection(): void
    {
        $config = UserFile::getUserById(Cookie::get('user'));
        try {
            self::$connection = new \PDO("mysql:host={$config['host']}", $config['username'], $config['password']);
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
        return self::$connection;
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
        if (self::$connection === null) {
            try {
                new \PDO("mysql:host=$host", $username, $password);
                return true;
            } catch (\PDOException $e) {
                return false;
            }
        }
    }

    /**
     * Query for showing all databases from the connection
     * 
     * @return array
     */
    public function showDatabases(): array
    {
        $stmt = self::$connection->query('SHOW DATABASES');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Query for selecting a database
     * 
     * @param string $databaseName
     * @return void
     */
    public function selectDatabase(string $databaseName): void
    {
        self::$connection->exec("USE $databaseName");
    }

    /**
     * Close the PDO connection
     * 
     * @return void
     */
    public static function close(): void
    {
        if (self::$connection !== null) {
            self::$connection = null;
        }
    }
}
