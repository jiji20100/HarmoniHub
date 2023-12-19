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

    public static function getPath(): array {
        try {
            $query = "SELECT file_path FROM " . self::$table;
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

    public static function getLastTracks(): array {
        try {
            $query = "SELECT * FROM " . self::$table . " ORDER BY uploaded_at DESC LIMIT 10";
            $stmt = self::$instance->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }

    public static function getTracksByGenreId(int $id): array {
        try {
            $query = "SELECT * FROM " . self::$table . " WHERE genre = $id";
            $stmt = self::$instance->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }

    public static function getBestTracks(): array {
        try {
            $query = "SELECT * FROM " . self::$table . " ORDER BY note DESC LIMIT 10";
            $stmt = self::$instance->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }
    


    public static function addTrack($trackName, $artistName, $genreId, $path, $createdAt, $user_id): bool {
       try {
            $query = "INSERT INTO " . self::$table . " (user_id, title, artist, genre, file_path, uploaded_at) VALUES (:user_id, :title, :artist, :genre, :file_path, :uploaded_at)";
            $stmt = self::$instance->prepare($query);
    
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":title", $trackName);
            $stmt->bindParam(":artist", $artistName);
            $stmt->bindParam(":genre", $genreId);
            $stmt->bindParam(":file_path", $path);
            $stmt->bindParam(":uploaded_at", $createdAt);
            $stmt->execute();
            

            return true;
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return false;
        }
    }

    public static function delete_track($trackId) {
        try {
            $sql = "DELETE FROM musics WHERE id = :id";
            $stmt = self::$instance->prepare($sql);
            $stmt->bindParam(":id", $trackId, \PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return false;
        }
    }

    public static function add_favorite($userId, $musicId) {

        try {
            $sql = "INSERT INTO favorites (user_id, music_id) VALUES (:userId, :musicId)";
            $stmt = self::$instance->prepare($sql);
            $stmt->bindParam(":userId", $userId);
            $stmt->bindParam(":musicId", $musicId);
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            throw $e;
        }
    }

    public static function getTrackById($trackId) {
        try {
            $sql = "SELECT * FROM musics WHERE id = :id";
            $stmt = self::$instance->prepare($sql);
            $stmt->bindParam(":id", $trackId, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            throw $e;
        }
    }

    public static function update_track($trackName, $genreId, $featuring, $trackId) {
        try {
            $sql = "UPDATE musics SET title = :title, featuring = :featuring, genre = :genreId WHERE id = :id";
            // . ($fileUpdated ? ", file_path = :filePath" : "") 
            $stmt = self::$instance->prepare($sql);
            $stmt->bindParam(":title", $trackName);
            $stmt->bindParam(":featuring", $featuring);
            $stmt->bindParam(":genreId", $genreId, \PDO::PARAM_INT);
            $stmt->bindParam(":id", $trackId, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            throw $e;
        }
    }
}

?>