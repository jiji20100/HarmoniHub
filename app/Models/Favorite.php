<?php

namespace Models;

use Source\Database;

class Favorite extends Database {
    protected static $table = "favorites";

    public static function addFavorite($userId, $trackId) {
        try {
            $sql = "INSERT INTO favorites (user_id, track_id) VALUES (:userId, :trackId)";
            $stmt = self::$instance->prepare($sql);
            $stmt->bindParam(":userId", $userId);
            $stmt->bindParam(":trackId", $trackId);
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            throw $e;
        }
    }

    public static function getFavoritesByUserId($userId) {
        try {
            // Sélectionner les colonnes nécessaires des deux tables en utilisant une jointure
            $sql = "SELECT favorites.id, favorites.user_id, favorites.music_id, musics.title, musics.file_path
                    FROM favorites
                    INNER JOIN musics ON favorites.music_id = musics.id
                    WHERE favorites.user_id = :userId";
    
            $stmt = self::$instance->prepare($sql);
            $stmt->bindParam(":userId", $userId, \PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            throw $e;
        }
    }
    

    public static function removeFavorite($userId, $trackId) {
        try {
            $sql = "DELETE FROM favorites WHERE user_id = :userId AND track_id = :trackId";
            $stmt = self::$instance->prepare($sql);
            $stmt->bindParam(":userId", $userId);
            $stmt->bindParam(":trackId", $trackId);
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            throw $e;
        }
    }
}

?>