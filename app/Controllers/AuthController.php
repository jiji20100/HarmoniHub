<?php
namespace Controllers;

use Source\Renderer;
use Source\Database;

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
        // Rediriger si déjà connecté
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
            header('Location: /home');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $erreurs = [];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Vérifie tous les champs
            if (empty($email) || empty($password)) {
                $erreurs[] = "Tous les champs sont obligatoires.";
            }

            if (empty($erreurs)) {
                $connexion = Database::getConnection();
                // Vérifie si l'email existe déjà
                $query = "SELECT * FROM users WHERE email = :email";
                $stmt = $connexion->prepare($query);
                $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        session_start();
                        $_SESSION['is_logged_in'] = true;
                        $_SESSION['user_id'] = $user['id'];
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
                header('Location: /login');
                exit();
            }

            header('Location: /login');
            exit();
        }

        // Si la méthode HTTP n'est pas POST, redirigez vers la page de connexion
        header('Location: /login');
        exit();
    }

    public function register_process() {

        // Rediriger si déjà connecté
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
            header('Location: home.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $surname = $_POST['surname'];
            $name = $_POST['name'];
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
                try {
                    $connexion = Database::getConnection();

                    // Vérifier si l'email est déjà utilisé
                    $stmt = $connexion->prepare("SELECT * FROM users WHERE email = :email");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();

                    if ($stmt->fetch()) {
                        $erreurs[] = "Cette adresse e-mail est déjà utilisée.";
                    } else {
                        // Insérer l'utilisateur dans la base de données
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $connexion->prepare("INSERT INTO users (name, surname, email, password) VALUES (:name, :surname, :email, :password)");
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':surname', $surname);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':password', $hashedPassword);
                        $stmt->execute();

                        // Redirection ou gestion de la session
                        $_SESSION['success'] = "Bravo, vous êtes maintenant inscris !";
                        $_SESSION['user_id'] = $connexion->lastInsertId();
                        header('Location: login');
                        exit;
                    }
                } catch (PDOException $e) {
                    $erreurs[] = "Erreur lors de l'inscription : " . $e->getMessage();
                }
            }

            // Gérer l'affichage des erreurs ici si nécessaire
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
        header("Location: /login");
        exit;
    }
}
?>
