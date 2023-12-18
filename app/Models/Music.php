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

    public static function addTrack($title, $artist, $genre, $file_path, $uploaded_at, $user_id): bool {
        try {
            $query = "INSERT INTO " . self::$table . " (title, artist, genre, file_path, uploaded_at, user_id) VALUES (:title, :artist, :genre, :file_path, :uploaded_at, :user_id)";
            $stmt = self::$instance->prepare($query);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":artist", $artist);
            $stmt->bindParam(":genre", $genre);
            $stmt->bindParam(":file_path", $file_path);
            $stmt->bindParam(":uploaded_at", $uploaded_at);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return false;
        }
    }
}

?>