<?php

namespace Controllers;

use PDOException;
use Source\Renderer;
use Source\Database;

class TrackController {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function track(): Renderer {
        return Renderer::make('tracks');
    }

    public function upload_track() {
        if (isset($_FILES['mp3_file'])) {
            // Récupérer le nombre de fichiers téléchargés
            $fileCount = count($_FILES['mp3_file']['name']);
    
            for ($i = 0; $i < $fileCount; $i++) {
                $target_dir = "../public/files/"; 
                $original_filename = $_FILES["mp3_file"]["name"][$i];
                $sanitized_filename = str_replace(' ', '_', $original_filename); // Remplace les espaces par des tirets bas
                $target_file = $target_dir . basename($sanitized_filename);
                $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
                if ($fileType != "mp3") {
                    $_SESSION['upload_message'] = 'Seuls les fichiers MP3 sont autorisés.';
                    $_SESSION['upload_message_type'] = 'danger';
                } else {
                    if (move_uploaded_file($_FILES["mp3_file"]["tmp_name"][$i], $target_file)) {
                        $this->save_track_info($sanitized_filename, $target_file);
                    } else {
                        $_SESSION['upload_message'] = 'Une erreur s\'est produite lors du téléchargement du fichier.';
                        $_SESSION['upload_message_type'] = 'danger';
                    }
                }
            }
        } else {
            $_SESSION['upload_message'] = 'Aucun fichier n\'a été téléchargé.';
            $_SESSION['upload_message_type'] = 'danger';
        }
    
        header('Location: /track');
        exit;
    }
    

    private function save_track_info($filename, $path) {
        $createdAt = date("Y-m-d H:i:s"); 

        try {
            $sql = "INSERT INTO musics (title, file_path, uploaded_at) VALUES (:title, :file_path, :uploaded_at)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":title", $filename);
            $stmt->bindParam(":file_path", $path);
            $stmt->bindParam(":uploaded_at", $createdAt);
            $stmt->execute();

            $_SESSION['upload_message'] = 'Le fichier ' . $filename . ' a été téléchargé avec succès et enregistré dans la base de données.';
            $_SESSION['upload_message_type'] = 'success';
        } catch (PDOException $e) {
            $_SESSION['upload_message'] = 'Erreur de base de données : ' . $e->getMessage();
            $_SESSION['upload_message_type'] = 'danger';
        }
    }
}
