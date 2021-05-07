<?php

namespace PhpYourAdimn\Core\Database;

use PhpYourAdimn\App\Helpers\File;
use PhpYourAdimn\App\Helpers\Cookie;

class Connection
{
    /**
     * @var PDO $pdo
     */
    public static $pdo = null;

    /**
     * Sets the pdo connection to mysql server
     * 
     * @return PDOException on failure
     * @return void on success
     */
    public static function make()
    {
        $config = File::getUserById(Cookie::get('user'));

        if (self::$pdo == null) {
            try {
                self::$pdo = new \PDO("mysql:host={$config['host']}", $config['username'], $config['password']);
            } catch (\PDOException $e) {

                die($e->getMessage());
            }
        }
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
    public static function validate($host, $username, $password): bool
    {
        if (self::$pdo == null) {
            try {
                new \PDO("mysql:host=$host", $username, $password);
                return true;
            } catch (\PDOException $e) {
                return false;
            }
        }
    }

    public static function showDatabases()
    {
        $stmt = self::$pdo->query('SHOW DATABASES');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function selectDatabase($database)
    {
        self::$pdo->exec("USE $database");
    }

    public static function disconect()
    {
        if (self::$pdo !== null) {
            self::$pdo = null;
        }
    }
}
