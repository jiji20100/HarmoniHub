<?php

namespace Controllers;

use Source\Renderer;
use Source\Database;
use Models\User;
use Models\Music;

class ProfileController {
    public function index(): Renderer {
        $user = User::getUserById($_SESSION['user_id']);
        $user_music = Music::getTracksByUserId($_SESSION['user_id']);
        
        $render = Renderer::make('Profile/profile', ['user' => $user, 'user_music' => $user_music]);
        unset($_SESSION['success']); 
        return $render;
    }

    public function edit(): Renderer {
        $user = User::getUserById($_SESSION['user_id']);
        $user_music = Music::getTracksByUserId($_SESSION['user_id']);
        $errors = $_SESSION['errors'] ?? [];

        $render = Renderer::make('Profile/edit', ['user' => $user, 'user_music' => $user_music, 'errors' => $errors]);
        unset($_SESSION['errors']); 
        return $render;
    }

    public function edit_process(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $email = $_POST['email'];
            //$password = $_POST['password'];
            //$password_confirm = $_POST['password_confirm'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $username = $_POST['username'];


            // Vérifie tous les champs
            if (empty($username)) $errors["username"] = "Le nom d'utilisateur est obligatoire.";
            if (empty($firstname)) $errors["firstname"] = "Le prénom est obligatoire.";
            if (empty($lastname)) $errors["lastname"] = "Le nom est obligatoire.";
            if (empty($email)) {
                $errors["email"] = "L'email est obligatoire.";
            } else {
                $user = User::getUserByEmail($email);
                if ($user) {
                    $errors["email"] = "Un utilisateur existe déjà avec cet e-mail.";
                }
            }

            /*
            // Vérifie si les mots de passe correspondent
            if ($password !== $password_confirm) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            }
            */

            if (empty($errors)) {
                $user = User::updateUser($_SESSION['user_id'], [
                    'email' => $email,
                    'name' => $firstname,
                    'surname' => $lastname,
                    'artist_name' => $username
                ]);

                if (!$user) {
                    $errors["global"] = "Erreur lors de la mise à jour de l'utilisateur.";
                }
            }
        } else {
            $errors["global"] = "Erreur lors de l'envoi du formulaire.";
        }

    
        $_SESSION['errors'] = $errors;
        if (empty($errors)) {
            $_SESSION['success'] = "Votre profil a bien été mis à jour.";
            header('Location: /profile');
        } else {
            header('Location: /profile/edit');
        }
    }
}
?>