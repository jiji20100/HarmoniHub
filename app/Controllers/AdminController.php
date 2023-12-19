<?php

namespace Controllers;

use Source\Renderer;
use Models\User;

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
        return Renderer::make('Admin/tracks');
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
}

?>