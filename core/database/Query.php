<?php

namespace PhpYourAdimn\Core\Database;

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

    public function __construct($pdo = null)
    {
        $this->pdo = $pdo;

  
    }

    /**
     * Query for showing all databases from the connection
     * 
     * @return array
     */
    public function getDatabases(): array
    {
        $statement = $this->pdo->query('SHOW DATABASES');

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
     * Query for showing all tables from the selected database
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
    public function getTables(): array
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
        // $table = $this->tableExists($table);

        $sql = "SHOW COLUMNS FROM $table";

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
        // $table = $this->tableExists($table);

        $sql = "SELECT * FROM $table";

        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function userQuery($query)
    {
        $statement = $this->pdo->prepare($query);
        
        $statement->execute();

        if (explode(' ', $query)[0] == 'SELECT') {
            $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $data;
        }
    }
}
