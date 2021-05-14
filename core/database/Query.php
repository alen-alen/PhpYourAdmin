<?php

namespace PhpYourAdimn\Core\Database;

class Query
{
    public $pdo;

    public function __construct($pdo=null)
    {
        $this->pdo=$pdo;
     
    
    }

    /**
     * Query for showing all databases from the connection
     * 
     * @return array
     */
    public function getDatabases(): array
    {
        
        $stmt = $this->pdo->query('SHOW DATABASES');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Query for showing all databases from the connection
     * 
     * @return array
     */
    public function getTables(): array
    {
        $stmt = $this->pdo->query('SHOW TABLES');

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

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
