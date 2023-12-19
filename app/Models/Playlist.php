<?php

namespace Models;

use Source\Database;

class Playlist extends Database {
    protected static $table = "playlists";
    protected static $tableLink = "links_playlist_music";


    public static function getPlaylistByUserId(int $id): array {
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

    public static function getPlaylistByNames(string $name, int $id): array {
        try {
            $query = "SELECT * FROM " . self::$table . " WHERE name = '$name' AND user_id = $id";
            $stmt = self::$instance->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }

    public static function getMusicByPlaylistId(int $id): array {
        try {
            $query = "SELECT * FROM " . self::$tableLink . " WHERE playlist_id = $id";
            $stmt = self::$instance->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }

    public static function createPlaylist(string $name, int $id): bool {
        try {
            $query = "INSERT INTO " . self::$table . " (name, user_id) VALUES ($name, $id)";
            $stmt = self::$instance->prepare($query);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return false;
        }
    }

    public static function addMusicToPlaylist(int $playlistId, int $musicId): bool {
        try {
            $query = "INSERT INTO " . self::$tableLink . " (playlist_id, music_id) VALUES ($playlistId, $musicId)";
            $stmt = self::$instance->prepare($query);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return false;
        }
    }

}

?>