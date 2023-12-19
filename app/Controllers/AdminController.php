<?php

namespace Controllers;

use Source\Renderer;
use Models\User;
use Models\Music;
use Models\Genre;

class AdminController
{
    public function index(): Renderer
    {
        return Renderer::make('Admin/admin');
    }
    public function admin_users_index(): Renderer
    {
        $users = User::getAllUsers();
        return Renderer::make('Admin/users', ['users' => $users]);
    }
    public function admin_tracks_index(): Renderer
    {
        $tracks = Music::getAllTracks();
        return Renderer::make('Admin/tracks', ['tracks' => $tracks]);
    }

    public function show_update_form_user() {
        $formHtml = '';
        if (isset($_POST['id'])) {
            $user_id = $_POST['id'];
            $users = User::getUserById($user_id);
            try {
                if ($users) {
                    foreach($users as $user){
                        $formHtml =  '<form action="/update_user" method="POST" enctype="multipart/form-data" class="update-form">';
                        $formHtml .= '<input type="hidden" name="id" value="' . htmlspecialchars($user['id']) . '">';

                        $formHtml .= '<label for="surname">Prénom :</label>';
                        $formHtml .= '<input type="text" name="surname" id="surname" value="' . htmlspecialchars($user['surname']) . '" required>';
                        $formHtml .= '<label for="name">Nom :</label>';
                        $formHtml .= '<input type="text" name="name" id="name" value="' . htmlspecialchars($user['name']) . '" required>';
                        $formHtml .= '<label for="artist_name">Nom d\'artiste :</label>';
                        $formHtml .= '<input type="text" name="artist_name" id="artist_name" value="' . htmlspecialchars($user['artist_name']) . '" required>';
                        $formHtml .= '<label for="email">Adresse mail :</label>';
                        $formHtml .= '<input type="text" name="email" id="email" value="' . htmlspecialchars($user['email']) . '" required>';
                        $formHtml .= '<label for="role_id">Rôle :</label>';
                        $formHtml .= '<input type="text" name="role_id" id="role_id" value="' . htmlspecialchars($user['role_id']) . '" required>';
                        $formHtml .= '<label for="created_at">Date de création :</label>';
                        $formHtml .= '<input type="text" name="created_at" id="created_at" value="' . htmlspecialchars($user['created_at']) . '" required>';
                        $formHtml .= '<button type="submit">Mettre à jour</button>';
                        $formHtml .= '</form>'; 
                    }
                } else {
                    $formHtml .= 'Utilisateur non trouvé.';
                }
            } catch (Exception $e) {
                $formHtml .= 'Erreur : ' . $e->getMessage();
            }
        } else {
            $formHtml .= 'Aucun ID de track spécifié.';
        }
        return $formHtml;
    }

    public function update_user() {
        if (isset($_POST['id'])) {
            $surname = $_POST['surname'] ?? ''; 
            $name = $_POST['name'] ?? ''; 
            $artist_name = $_POST['artist_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $role_id = $_POST['role_id'] ?? '';
            $created_at = $_POST['created_at'] ?? '';
            try {
                $result = User::update_user($surname, $name, $artist_name, $email, $role_id, $created_at, $_POST['id']);
                $_SESSION['user_message'] = "Le user " . $_POST['name'] . " a bien été modifié";
                $_SESSION['user_message_type'] = 'success';
            } catch (PDOException $e) {
                $_SESSION['user_message'] = 'Erreur de base de données : ' . $e->getMessage();
                $_SESSION['user_message_type'] = 'danger';
            }
        }
        header('Location: /admin_users');
        exit;
    }

    public function delete_user() {
        if (isset($_POST['id'])) {
            
            $user_id = $_POST['id'];
            if (User::delete_user($user_id)) {
                $_SESSION['user_message'] = 'User supprimé avec succès.';
                $_SESSION['user_message_type'] = 'success';
            } else {
                $_SESSION['user_message'] = 'Erreur lors de la suppression du user.';
                $_SESSION['user_message_type'] = 'danger';
            }

            header('Location: /admin_users');
            exit;
        }
    }

    public function update_track_admin() {
        if (isset($_POST['id'])) {
            $trackName = $_POST['track_name'] ?? ''; 
            $genreId = $_POST['genre'] ?? ''; 
            $featuring = $_POST['featuring'] ?? '';
            try {
                $result = Music::update_track($trackName, $genreId, $featuring, $_POST['id']);
                $_SESSION['track_admin_message'] = "Le track " . $_POST['track_name'] . " a bien été modifié";
                $_SESSION['track_admin_message_type'] = 'success';
            } catch (PDOException $e) {
                $_SESSION['track_admin_message'] = 'Erreur de base de données : ' . $e->getMessage();
                $_SESSION['track_admin_message_type'] = 'danger';
            }
        }
        header('Location: /admin_tracks');
        exit;
    }

    public function delete_track_admin() {
        if (isset($_POST['id'])) {
            $trackId = $_POST['id'];
            $file_path = Music::getPath();
            $file_full_path = $_SERVER['DOCUMENT_ROOT'] . $file_path[0]["file_path"];
            // Étape 2 : Supprimer le fichier s'il existe
            if (file_exists($file_full_path)) {
                unlink($file_full_path);
            }
            if (Music::delete_track($trackId)) {
                $_SESSION['track_admin_message'] = 'Track supprimé avec succès.';
                $_SESSION['track_admin_message_type'] = 'success';
            } else {
                $_SESSION['track_admin_message'] = 'Erreur lors de la suppression du track.';
                $_SESSION['track_admin_message_type'] = 'danger';
            }

            header('Location: /admin_tracks');
            exit;
        }
    }

    public function show_update_form_track_admin() {
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

?>