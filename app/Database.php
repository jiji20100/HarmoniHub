<?php

namespace Source;

use Source\Config;
use PDO;
use PDOException;

class Database {
    protected static $instance = null;
    protected static $table = null;

    private function __construct() {
        // Constructeur privé pour empêcher l'instanciation directe
    }

    public static function getConnection(): \PDO {
        if (self::$instance === null) {
            try {
                $config = new Config();
                self::$instance = new \PDO(
                    "mysql:host=localhost;dbname=" . $config->DB_NAME, 
                    $config->DB_USERNAME, 
                    $config->DB_PASSWORD, 
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
                    ]
                );
            } catch (\PDOException $e) {
                echo $e->getMessage();
                die();
            }
        }
        return self::$instance;
    }

    public static function disconnect() {
        self::$instance = null;
    }

    public static function getAll(): \PDOStatement {
        try {
            //TODO : récupérer la connexion à la base de données
            //$connexion = self::getConnection();
            $connexion = self::$instance;
            $query = "SELECT * FROM " . self::$table;
            $stmt = $connexion->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }
}

?>
