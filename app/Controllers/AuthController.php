<?php

namespace Controllers;

use Source\Renderer;

class AuthController
{
    public function index(): Renderer
    {
        $this->isConnected();
        return Renderer::make('Auth/auth');
    }


    public function login(): Renderer
    {
        $this->isConnected();
        return Renderer::make('Auth/login');
    }

    public function register(): Renderer
    {
        $this->isConnected();
        return Renderer::make('Auth/register');
    }

    public function reset_password(): Renderer
    {
        return Renderer::make('Auth/reset_password');
    }


    private function isConnected(): void
    {
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
            header('Location: home.php');
            exit;
        }
    }

    public function login_process(): Renderer
    {
        include_once '../config/config.php';

        $erreurs = array();

        // Vérifie si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Vérifie tous les champs
            if (empty($email) || empty($password)) {
                $erreurs[] = "Tous les champs sont obligatoires.";
            }

            if (empty($erreurs)) {
                // Vérifie si l'email existe déjà
                $query = "SELECT * FROM users WHERE email = :email";
                $stmt = $connexion->prepare($query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        header('Location: index.php');
                        exit();
                    } else {
                        $erreurs[] = "Mot de passe incorrect.";
                    }
                } else {
                    $erreurs[] = "Aucun utilisateur trouvé avec cet e-mail.";
                }
            }
        }
        $connexion = null;

        // Si l'authentification a échoué
        if (!empty($erreurs)) {
            $_SESSION['erreurs'] = $erreurs;
            header('Location: login.php');
            exit();
        }
    }
}

?>