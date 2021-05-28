<?php

namespace PhpYourAdimn\Core\Database;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\File\UserFile;

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
     * @var array|null $config
     */
    private $config = null;

    public Request $request;

    public UserFile $userFile;

    private function __construct(Request $request, UserFile $userFile)
    {
        $this->userFile = $userFile;
        $this->request = $request;

        $this->setConfig();

        if ($this->config) {
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
        $dns = $this->request->has('db') ?
            "mysql:host={$this->config['host']};dbname={$this->request->parameter('db')}" :
            "mysql:host={$this->config['host']};";

        try {
            $this->pdo = new \PDO($dns, $this->config['username'], $this->config['password']);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Set the connection configuration data
     */
    private function setConfig()
    {
        $userId = $this->request->cookie->has('user') ?
            $this->request->cookie->get('user') :
            false;

        $this->config = $this->userFile->getUserById($userId) ?
            $this->userFile->getUserById($userId) :
            null;
    }

    /**
     * Create an instance of this class and return it
     * 
     * @return Connection
     */
    public static function getInstance(Request $request, UserFile $userFile): Connection
    {
        if (!self::$instance) {
            self::$instance = new Connection($request, $userFile);
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
