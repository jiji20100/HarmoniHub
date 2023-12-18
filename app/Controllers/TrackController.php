<?php

namespace Controllers;

use PDOException;
use Source\Renderer;
use Source\Database;
use Models\Music;
use Models\User;
use Models\Genre;

class TrackController {
    
    public function track(): Renderer {
        $musics = Music::getTracksByUserId($_SESSION['user_id']);
        $genres = Genre::getGenres();
        return Renderer::make('tracks', ['musics' => $musics, 'genres' => $genres]);
    }
    
    public function upload_track() {
        if (isset($_FILES['mp3_file'])) {
            // Vos autres variables
            // ...
    
            for ($i = 0; $i < $fileCount; $i++) {
                $original_filename = $_FILES["mp3_file"]["name"][$i];
                $fileType = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
    
                if ($fileType != "mp3") {
                    // Votre gestion des erreurs
                } else {
                    // Créer un nom de fichier en utilisant le nom de la piste et en ajoutant un identifiant unique
                    $sanitized_trackName = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $trackName)); // Nettoyer et sécuriser le nom
                    $uniqueSuffix = time() . '-' . rand(0, 99999); // Suffixe unique pour éviter les conflits de nom
                    $new_filename = $sanitized_trackName . '-' . $uniqueSuffix . '.mp3';
    
                    $target_file = $target_dir . $new_filename;
    
                    if (move_uploaded_file($_FILES["mp3_file"]["tmp_name"][$i], $target_file)) {
                        $this->save_track_info($trackName, $genreId, $featuring, $new_filename, $target_file);
                    } else {
                        // Votre gestion des erreurs
                    }
                }
            }
        }
        if (isset($_FILES['mp3_file'])) {
            // Récupérer le nombre de fichiers téléchargés
            $fileCount = count($_FILES['mp3_file']['name']);
            $trackName = $_POST['track_name'] ?? ''; // Nom de la piste
            $genreId = $_POST['genre'] ?? ''; // ID du genre
            $featuring = $_POST['featuring'] ?? ''; // Information sur le featuring
    
            for ($i = 0; $i < $fileCount; $i++) {
                $target_dir = "../public/files/";
                $original_filename = $_FILES["mp3_file"]["name"][$i];
                $fileType = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
                $sanitized_filename = str_replace(' ', '_', $original_filename); // Remplace les espaces par des tirets bas
                $target_file = $target_dir . basename($sanitized_filename);
    
                if ($fileType != "mp3") {
                    $_SESSION['upload_message'] = 'Seuls les fichiers MP3 sont autorisés.';
                    $_SESSION['upload_message_type'] = 'danger';
                } else {
                    $sanitized_trackName = preg_replace('/[^A-Za-z0-9_\-]/', '', str_replace(' ', '_', $trackName));
                    $new_filename = $sanitized_trackName . '.mp3';
                    $target_file = $target_dir . $new_filename;
                    $_SESSION['target_file'] = $target_file;
                    if (move_uploaded_file($_FILES["mp3_file"]["tmp_name"][$i], $target_file)) {
                        $path_in_bdd = "/files/" . $new_filename;
                        $this->save_track_info($trackName, $genreId, $featuring, $sanitized_filename, $path_in_bdd);
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
    

    private function save_track_info($trackName, $genreId, $featuring, $filename, $path) {
        $createdAt = date("Y-m-d H:i:s"); 
        try {

            $artistName = User::getArtistNameById($_SESSION['user_id']);            
            $result = Music::addTrack($trackName, $artistName, $genreId, $filename, $path, $createdAt, $_SESSION['user_id']);

            $_SESSION['upload_message'] = 'Le fichier ' . $filename . ' a été téléchargé avec succès et enregistré dans la base de données.';
            $_SESSION['upload_message_type'] = 'success';
        } catch (PDOException $e) {
            $_SESSION['upload_message'] = 'Erreur de base de données : ' . $e->getMessage();
            $_SESSION['upload_message_type'] = 'danger';
        }
    }
}
