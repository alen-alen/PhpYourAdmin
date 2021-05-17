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
        $stmt = $this->pdo->query('SHOW DATABASES');

        $databases = $stmt->fetchAll(\PDO::FETCH_ASSOC);

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
    public function createDatabase($dbName, $charset, $collate)
    {
        $sql = "CREATE DATABASE $dbName CHARACTER SET $charset COLLATE $collate";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();
    }

    /**
     * Query for showing all tables from the selected database
     * 
     * @return array
     */
    public function getTables(): array
    {
        $stmt = $this->pdo->query('SHOW TABLES');

        $tables = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $tables = array_map(function ($table) {
            array_values($table);
            return array_pop($table);
        }, $tables);

        $this->tables = $tables;
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
        $table = $this->tableExists($table);

        $sql = "SHOW COLUMNS FROM $table";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    /**
     * Returns the table columns
     * 
     * @param string $table table name
     * @return array
     */
    public function getCollationById($id)
    {
        $sql = "SHOW COLLATION WHERE ID=:id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Select everything from table $table
     * 
     * @param string $table table name
     * @return array
     */
    public function selectAll(string $table): array
    {
        $table = $this->tableExists($table);

        $sql = "SELECT * FROM $table";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Check if the table exists in the database
     * @param string $tableName
     */
    private function tableExists($tableName)
    {
        $table = array_values(array_filter($this->tables, function ($tbl) use ($tableName) {
            return $tableName === $tbl ? $tbl : null;
        }));
        return !empty($table[0]) ? $table[0] : die('Table does not exist');
    }
}
