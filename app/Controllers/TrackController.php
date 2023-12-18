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
        $genres = Genre::getAllGenres();
        return Renderer::make('tracks', ['musics' => $musics, 'genres' => $genres]);
    }
    
    public function upload_track() {
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
            $result = Music::addTrack($trackName, $artistName, $genreId, $path, $createdAt, $_SESSION['user_id']);
            $_SESSION['upload_message'] = 'Le fichier ' . $filename . ' a été téléchargé avec succès et enregistré dans la base de données.';
            $_SESSION['upload_message_type'] = 'success';
        } catch (PDOException $e) {
            $_SESSION['upload_message'] = 'Erreur de base de données : ' . $e->getMessage();
            $_SESSION['upload_message_type'] = 'danger';
        }
    }

    public function update() {
        if (isset($_POST['id'])) {
            $trackName = $_POST['track_name'] ?? ''; 
            $genreId = $_POST['genre'] ?? ''; 
            $featuring = $_POST['featuring'] ?? '';
            try {
                $result = Music::update_track($trackName, $genreId, $featuring, $_POST['id']);
                $_SESSION['track_message'] = "Le track " . $_POST['track_name'] . " a bien été modifié";
                $_SESSION['track_message_type'] = 'success';
            } catch (PDOException $e) {
                $_SESSION['track_message'] = 'Erreur de base de données : ' . $e->getMessage();
                $_SESSION['track_message_type'] = 'danger';
            }
        }
        header('Location: /track');
        exit;
    }

    public function delete_track() {
        if (isset($_POST['id'])) {
            
            $trackId = $_POST['id'];
            $file_path = Music::getPath();
            $file_full_path = $_SERVER['DOCUMENT_ROOT'] . $file_path[0]["file_path"];
            // Étape 2 : Supprimer le fichier s'il existe
            if (file_exists($file_full_path)) {
                unlink($file_full_path);
            }
            if (Music::delete_track($trackId)) {
                $_SESSION['track_message'] = 'Track supprimé avec succès.';
                $_SESSION['track_message_type'] = 'success';
            } else {
                $_SESSION['track_message'] = 'Erreur lors de la suppression du track.';
                $_SESSION['track_message_type'] = 'danger';
            }

            header('Location: /track');
            exit;
        }
    }

    public function show_update_form_track() {
        $formHtml = '';
        if (isset($_POST['id'])) {
            $trackId = $_POST['id'];
            try {
                $track = Music::getTrackById($trackId);
                $genres = Genre::getAllGenres();
                if ($track) {
                    $formHtml =  '<form action="/update_track" method="POST" enctype="multipart/form-data" class="update-form">';
                    $formHtml .= '<input type="hidden" name="id" value="' . htmlspecialchars($track['id']) . '">';

                    $formHtml .= '<label for="track_name">Titre :</label>';
                    $formHtml .= '<input type="text" name="track_name" id="track_name" value="' . htmlspecialchars($track['title']) . '" required>';

                    $formHtml .= '<label for="featuring">Featuring :</label>';
                    $formHtml .= '<input type="text" name="featuring" id="featuring" value="' . htmlspecialchars($track['featuring']) . '">';

                    $formHtml .= '<label for="genre">Genre :</label>';
                    $formHtml .= '<select name="genre" id="genre">';
                    foreach ($genres as $genre) {
                        $selected = ($genre['id'] == $track['genre']) ? ' selected' : '';
                        $formHtml .= '<option value="' . htmlspecialchars($genre['id']) . '"' . $selected . '>' . htmlspecialchars($genre['name']) . '</option>';
                    }
                    $formHtml .= '</select>';

                    $formHtml .= '<label for="track_file">Changer le fichier MP3 :</label>';
                    $formHtml .= '<input type="file" name="track_file" id="track_file">';

                    $formHtml .= '<button type="submit">Mettre à jour</button>';
                    $formHtml .= '</form>';
                } else {
                    $formHtml .= 'Track non trouvé.';
                }
            } catch (Exception $e) {
                $formHtml .= 'Erreur : ' . $e->getMessage();
            }
        } else {
            $formHtml .= 'Aucun ID de track spécifié.';
        }

        return $formHtml;
    }

    
}
