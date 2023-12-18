<?php

namespace Models;

use Source\Database;

class Music extends Database {
    protected static $table = "musics";

    //TODO REMOVE CAUSE IT'S ALREADY IN DATABASE.PHP
    public static function getTracks(): array {
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

    public static function getTracksByUserId(int $id): array {
        try {
            $query = "SELECT * FROM " . self::$table . " WHERE user_id = $id";
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