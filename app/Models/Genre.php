<?php

namespace Models;

use Source\Database;

class Genre extends Database {
    protected string $table = "genres";

    //TODO REMOVE CAUSE IT'S ALREADY IN DATABASE.PHP
    public static function getGenres(): \PDOStatement {
        try {
            $query = "SELECT * FROM " . self::$table;
            $stmt = self::$instance->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }
}

?>