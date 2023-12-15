<?php

namespace Source;

use Source\Config;

class Database {
    protected static \PDO $connection;
    protected string $table;

    public function __construct() {
        $config = new Config();
        try {
            $this->db = new \PDO("mysql:host=localhost;dbname=" . 
                $config->DB_NAME, 
                $config->DB_USERNAME, 
                $config->DB_PASSWORD, 
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
            ]);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            die();
        }

        $this->table = strtolower((new \ReflectionClass($this))->getShortName()) . "s";
    }

    protected function getDatabase() {
        return $this->db;
    }

    public function all() {
        $query = $this->getDatabase()->query("SELECT * FROM {$this->table}");
        return $query->fetchAll();
    }
}

?>