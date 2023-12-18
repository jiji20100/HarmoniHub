<?php

namespace Models;

use Source\Database;

class User extends Database {
    protected static $table = "users";

    public static function getUserById(int $id): array | bool {
        try {
            $query = "SELECT * FROM " . self::$table . " WHERE id = $id";
            $stmt = self::$instance->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }

    public static function getUserByEmail(string $email): array | bool {
        try {
            $query = "SELECT * FROM " . self::$table . " WHERE email = '$email'";
            $stmt = self::$instance->prepare($query);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }

    public static function getArtistNameById(int $id): string | bool {
        try {
            $query = "SELECT artist_name FROM " . self::$table . " WHERE id = $id";
            $stmt = self::$instance->prepare($query);
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return '';
        }
    }

    public static function updateUser(int $id, array $data): bool {
        try {
            $query = "UPDATE " . self::$table . " SET ";

            foreach($data as $key => $value) {
                $query .= "$key = '$value', ";
            }

            $query = rtrim($query, ", ");
            $query .= " WHERE id = $id";

            $stmt = self::$instance->prepare($query);
            $stmt->execute($values);

            return true;
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteUser(int $id): bool {
        try {
            $query = "DELETE FROM " . self::$table . " WHERE id = :id";
            $stmt = $this->instance->prepare($query);
            $stmt->execute([':id' => $id]);

            return true;
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return false;
        }
    }
}

?>