<?php

namespace PhpYourAdmin\Core\Database;

use PhpYourAdmin\App\Models\MysqlUser;

class Query
{
    /**
     * @var PDO $pdo 
     */
    public $pdo;

    /**
     * All tables for the selected database
     * @var array $tables
     */
    public array $tables;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->pdo = $connection->getConnection();
    }

    /**
     * Try to establish a connection to  mysql 
     * 
     * @param string $host
     * @param string $username
     * @param string $password
     * 
     * @return PDOException  on failure 
     */
    public function validateConnection(string $host, string $username, string $password)
    {
        if (!$this->pdo) {
            new \PDO("mysql:host=$host", $username, $password);
        }
    }

    /**
     * Return all Mysql users
     * 
     * @return array
     */
    public function getMysqlUsers()
    {
        $sql = 'SELECT user,host,password,grant_priv FROM mysql.user';

        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Create a new MySql user
     * 
     * @param MysqlUser $user
     * @return $errorMessage on failure
     */
    public function createSqlUser(MysqlUser $user)
    {
        $sql = "CREATE USER :username@:host identified by :password";

        $statement = $this->pdo->prepare($sql);

        $statement->execute([':username' => $user->username, ':host' => $user->host, ':password' => $user->password]);
    }

    /**
     * Sets Privileges for selected $user
     * 
     * @param MysqlUser $user
     * @return void
     */
    public function setUserPrivileges(MysqlUser $user)
    {
        $sql = "GRANT";

        foreach ($user->privileges as $privilige) {
            $sql .= " $privilige ";
        }
        $sql .= "ON *.* TO :username@:host";

        if ($user->grantOption) {
            $sql .= " $user->grantOption";
        }
        $statement = $this->pdo->prepare($sql);

        $statement->execute([':username' => $user->username, ':host' => $user->host]);
    }

    /**
     * Delete a user form Mysql Server
     * 
     * @param string $username
     * @param string $host
     * @return void
     */
    public function deleteSqlUser($username, $host)
    {
        $sql = "DROP USER :username@:host";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([':username' => $username, ':host' => $host]);
    }

    /**
     * Query for showing all databases from the connection
     * 
     * @return array
     */
    public function getDatabases(): array
    {
        $statement = $this->pdo->prepare('SHOW DATABASES');

        $statement->execute();

        $databases = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $databases = array_map(function ($database) {
            array_values($database);
            return array_pop($database);
        }, $databases);

        return $databases;
    }

    /**
     * Query for creating a database
     * 
     * @param string $dbName
     * @param string $charset
     * @param string $collate
     */
    public function createDatabase(string $dbName, string $charset, string $collate)
    {
        $sql = "CREATE DATABASE $dbName CHARACTER SET $charset COLLATE $collate";

        $statement = $this->pdo->prepare($sql);

        $statement->execute();
    }

    /**
     * Query for showing all tables
     * 
     * @return array
     */
    public function allTables(): array
    {
        $statement = $this->pdo->query('SELECT * FROM information_schema.tables;');

        $tables = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $tables;
    }

    /**
     * Query for showing all tables from the selected database
     * 
     * @return array
     */
    public function getDatabaseTables(): array
    {
        $statement = $this->pdo->query('SHOW TABLES');

        $tables = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $tables = array_map(function ($table) {
            array_values($table);
            return array_pop($table);
        }, $tables);

        return $tables;
    }

    /**
     * Returns the selected table columns
     * 
     * @param string $table table name
     * @return array
     */
    public function getTableColumns(string $table): array
    {
        $sql = "SHOW COLUMNS FROM $table";

        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        while ($columns = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $thisColumns[] = $columns['Field'];
        }
        return $thisColumns;
    }

    /**
     * Returns the table columns
     * 
     * @param string $table table name
     * @return array
     */
    public function showCollations(): array
    {
        $sql = "SHOW COLLATION";

        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Returns the table columns
     * 
     * @param string $table table name
     * @return array
     */
    public function getCollationById($id)
    {
        $sql = "SHOW COLLATION WHERE ID = :id";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([':id' => $id]);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Select everything from table $table
     * 
     * @param string $table table name
     * @return array
     */
    public function selectAll(string $table): array
    {
        $sql = "SELECT * FROM $table";

        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Executes the raw sql query
     * 
     * @param string $query user input query
     * 
     * @return  $data|PDO exception
     */
    public function rawSql($query)
    {
        $statement = $this->pdo->prepare($query);

        if (!$statement->execute()) {
            throw new \Exception($statement->errorInfo()[2]);
        }
        if (explode(' ', $query)[0] == 'SELECT') {
            $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $data;
        }
    }
}
