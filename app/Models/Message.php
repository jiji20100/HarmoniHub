<?php

namespace Models;

use Source\Database;

class Message extends Database {
    protected static $table = "messages";

    public static function getMessageByUserId(int $id): array {
        try {
            $query = "SELECT * FROM " . self::$table . " WHERE user_id = :id";
            $stmt = self::$instance->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }

}
?>
