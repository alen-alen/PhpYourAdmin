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

        if (isset($_GET['db'])) {
            try {
                self::$connection = new \PDO("mysql:host={$config['host']};dbname={$_GET['db']}", $config['username'], $config['password']);
            } catch (\PDOException $e) {

                die($e->getMessage());
            }
        } else {
            try {
                self::$connection = new \PDO("mysql:host={$config['host']}", $config['username'], $config['password']);
            } catch (\PDOException $e) {

                die($e->getMessage());
            }
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
    public function getDatabases(): array
    {
        $stmt = self::$connection->query('SHOW DATABASES');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Query for showing all databases from the connection
     * 
     * @return array
     */
    public function getTables(): array
    {
        $stmt = self::$connection->query('SHOW TABLES');

        $tables = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $tables = array_map(function ($table) {
            $table = array_values($table);
            return array_pop($table);
        }, $tables);

        return $tables;
    }

    /**
     * Returns the table columns
     * 
     * @param string $table table name
     * @return array
     */
    public function getTableColumns(string $table): array
    {
        $sql = "SHOW COLUMNS FROM $table;";

        $stmt = self::$connection->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Return everything from table $table
     * 
     * @param string $table table name
     * @return array
     */
    public function select(string $table): array
    {
        $sql = "SELECT * FROM $table";

        $stmt = self::$connection->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
