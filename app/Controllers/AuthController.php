<?php
namespace Controllers;

use Source\Renderer;
use Models\User;
use Models\Playlist;

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
            $login = $_POST['login'];
            $password = $_POST['password'];

            // Vérifie tous les champs
            if (empty($login) || empty($password)) {
                $erreurs[] = "Tous les champs sont obligatoires.";
            }

            if (empty($erreurs)) {

                //check if its an email or username
                if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
                    $user = User::getUserByEmail($login);
                } else {
                    $user = User::getUserByArtistName($login);
                }

                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['is_logged_in'] = true;
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['welcome_message'] = "Bienvenue " . $user['name'] . " " . $user['surname'] . " !";
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
            $infos = "";

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
                        $_SESSION['infos'] = "Votre username est : " . $username;
                    }
                    if (User::getUserByArtistName($username)) {
                        $username = $username . time();
                        $_SESSION['infos'] = "Votre username est : " . $username;
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

                        $user = User::getUserByEmail($email);

                        $this->create_user_env($user);

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

    private function create_user_env($user) {
        //crée dossier de l'utilisateur (avec son id)
        $path = '../public/files/' . $user['id'] . '/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        //crée playlist par défaut
        $playlist = Playlist::createPlaylist("Upload", $user['id']);
        $playlist = Playlist::createPlaylist("Library", $user['id']);
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
