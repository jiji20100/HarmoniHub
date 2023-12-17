<?php

namespace Source;

use Source\Config;
use PDO;
use PDOException;

class Database {
    private static $instance = null;

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

    public function getGenres() {
        try {
            $sql = "SELECT id, name FROM genre";
            $stmt = self::$instance->prepare($sql); // Utilisez self::$instance qui est votre objet PDO
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }
}

?>