<?php
namespace Controllers;

use Source\Renderer;
use Models\User;

class AuthController {
    public function index(): Renderer {
        return Renderer::make('Auth/auth');
    }

    public function login(): Renderer {
        return Renderer::make('Auth/login');
    }

    public function register(): Renderer {
        return Renderer::make('Auth/register');
    }

    public function reset_password(): Renderer {
        return Renderer::make('Auth/reset_password');
    }

    public function login_process(): Renderer {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $erreurs = [];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Vérifie tous les champs
            if (empty($email) || empty($password)) {
                $erreurs[] = "Tous les champs sont obligatoires.";
            }

            if (empty($erreurs)) {

                $user = User::getUserByEmail($email);
                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['is_logged_in'] = true;
                        $_SESSION['user_id'] = $user['id'];
                        unset($_SESSION['error']);
                        header('Location: /home');
                        exit();
                    } else {
                        $erreurs[] = "Mot de passe incorrect.";
                    }
                } else {
                    $erreurs[] = "Aucun utilisateur trouvé avec cet e-mail.";
                }
            }

            if (!empty($erreurs)) {
                $_SESSION['error'] = implode(' ', $erreurs);
            }
        }

        // Si la méthode HTTP n'est pas POST, redirigez vers la page de connexion
        header('Location: /login');
        exit();
    }

    public function register_process() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $surname = $_POST['surname'];
            $name = $_POST['name'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConfirmation = $_POST['password_confirmation'];

            $erreurs = [];

            // Validation des données
            if (empty($surname) || empty($name) || empty($email) || empty($password)) {
                $erreurs[] = "Tous les champs sont obligatoires.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erreurs[] = "Format d'email invalide.";
            }

            if ($password !== $passwordConfirmation) {
                $erreurs[] = "Les mots de passe ne correspondent pas.";
            }

            if (empty($erreurs)) {

                if (User::getUserByEmail($email)) {
                    $erreurs[] = "Un utilisateur existe déjà avec cet e-mail.";
                } else {
                    if (!$username) {
                        $username = $name . $surname;
                    }
                    if (User::getUserByArtistName($username)) {
                        $username = $username . time();
                    }

                    $user = User::createUser([
                        'name' => $name,
                        'surname' => $surname,
                        'artist_name' => $username,
                        'email' => $email,
                        'password' => password_hash($password, PASSWORD_DEFAULT)
                    ]);

                    if (!$user) {
                        $erreurs[] = "Erreur lors de l'inscription.";
                    } else {
                        $_SESSION['success'] = "Bravo, vous êtes maintenant inscris !";
                        $_SESSION['user_id'] = $user['id'];
                        unset($_SESSION['errors']);
                        header('Location: /login');
                        exit();
                    }
                }
            }

            if (!empty($erreurs)) {
                $_SESSION['errors'] = implode(' ', $erreurs);
                header('Location: /register');
                exit();
            }            
        }
    }

    public function logout()
    {
        $_SESSION = array(); // Efface les données de la session
        
        if (ini_get("session.use_cookies")) { // Supprime le cookie de session s'il existe
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: /");
        exit;
    }
}
?>
