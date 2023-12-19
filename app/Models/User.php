<?php

namespace Models;

use Source\Database;

class User extends Database {
    protected static $table = "users";

    public static function getAllUsers(): array | bool {
        try {
            $query = "SELECT id, surname, name, artist_name, email, role_id, created_at FROM " . self::$table;
            $stmt = self::$instance->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return [];
        }
    }

    public static function getUserById($id): array | bool {
        try {
            $query = "SELECT * FROM " . self::$table . " WHERE id = :id";
            $stmt = self::$instance->prepare($query);
            $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
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

    public static function getUserByArtistName(string $artist_name): array | bool {
        try {
            $query = "SELECT * FROM " . self::$table . " WHERE artist_name = '$artist_name'";
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

    public static function createUser(array $data): bool {
        try {
            $query = "INSERT INTO " . self::$table . " (";

            foreach($data as $key => $value) {
                $query .= "$key, ";
            }

            $query = rtrim($query, ", ");
            $query .= ") VALUES (";

            foreach($data as $key => $value) {
                $query .= ":$key, ";
            }

            $query = rtrim($query, ", ");
            $query .= ")";

            $stmt = self::$instance->prepare($query);
            $stmt->execute($data);

            return true;
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return false;
        }
    }

    public static function updateUser(int $user_id, array $data): bool {
        try {
            $query = "UPDATE " . self::$table . " SET ";
        
            foreach ($data as $key => $value) {
                $query .= "$key = :$key, ";
            }
        
            $query = rtrim($query, ", ");
            $query .= " WHERE id = $user_id;";
                
            $stmt = self::$instance->prepare($query);
            $stmt->execute($data);
        
            return true;
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return false;
        }
    }    
    

    public static function update_user($surname, $name, $artist_name, $email, $role_id, $created_at, $user_id): bool {
        try {
            $sql = "UPDATE users SET surname = :surname, name = :name, artist_name = :artist_name, email = :email, role_id = :role_id, created_at = :created_at WHERE id = :id";
            $stmt = self::$instance->prepare($sql);
            $stmt->bindParam(":surname", $surname);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":artist_name", $artist_name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":role_id", $role_id);
            $stmt->bindParam(":created_at", $created_at);
            $stmt->bindParam(":id", $user_id, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            throw $e;
        }
    }

    public static function delete_user($id): bool {
        try {
            $query = "DELETE FROM " . self::$table . " WHERE id = :id";
            $stmt = self::$instance->prepare($query);
            $stmt->execute([':id' => $id]);

            return true;
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return false;
        }
    }
}

?>