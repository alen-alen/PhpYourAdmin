<?php

namespace PhpYourAdimn\Core\Database;

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\File\UserFile;
use PhpYourAdimn\Core\Log\FileLogger;

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

    /**
     * @var Request $request
     */
    public Request $request;

    /**
     * @var UserFile $userFile
     */
    public UserFile $userFile;

    /**
     * @var FileLogger $logger
     */
    public FileLogger $logger;

    /**
     * @param Request $request
     * @param UserFile $userFile
     * @param FileLogger $logger
     */
    private function __construct(Request $request, UserFile $userFile, FileLogger $logger)
    {
        $this->userFile = $userFile;
        $this->request = $request;
        $this->logger = $logger;

        $this->setConfig();

        if ($this->config) {
            return $this->createConnection();
        }
    }

    /**
     * Creates a connection with the logged in user's credentials
     * 
     * @return void
     */
    private function createConnection(): void
    {
        $dns = "mysql:host={$this->config['host']};";
        $dns .= $this->request->has('db') ? "dbname={$this->request->parameter('db')}" : "";

        try {
            $this->pdo = new \PDO($dns, $this->config['username'], $this->config['password']);
        } catch (\PDOException $e) {

            $this->logger->error($e->getMessage);
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
    public static function getInstance(Request $request, UserFile $userFile, FileLogger $logger): Connection
    {

        if (!self::$instance) {
            self::$instance = new Connection($request, $userFile, $logger);
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
