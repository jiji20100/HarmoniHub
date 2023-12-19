<?php
namespace Controllers;

use Source\Renderer;
use Models\User;
use Models\Playlist;

//a modifier
use Source\Database;
use Source\MailConfig;
use \PDO;

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

    public function make_reset_password(): Renderer {
        return Renderer::make('Auth/make_reset_password');
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

    public function send_reset_password(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $email = $_POST['email_fo_reset'];

            $erreurs = [];


            // Validation des données
            if (empty($email)) {
                $erreurs[] = "vous devez entrer un email";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erreurs[] = "Format d'email invalide.";
            }

            if (empty($erreurs)) {
                try {
                    $connexion = Database::getConnection();

                    // Vérifier si l'email est déjà utilisé
                    $stmt = $connexion->prepare("SELECT * FROM users WHERE email = :email");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();

                    if ($stmt->fetch()) {
                        //ici il faut envoyer l'email
                        $token = bin2hex(random_bytes(16));
                        $token_hash = hash("sha256", $token);
                        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);
                        
                        $sql = "UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";
                        $stmt = $connexion->prepare($sql);
                        
                        // Bind the parameters with data types
                        $stmt->bindParam(1, $token_hash, \PDO::PARAM_STR);
                        $stmt->bindParam(2, $expiry, \PDO::PARAM_STR);
                        $stmt->bindParam(3, $email, \PDO::PARAM_STR);
                        
                        $stmt->execute();
                        echo "the token was set\n";
                        echo "tokenhash : " .$token_hash;
                        echo "token : " .$token;

                        if($stmt){
                            $emailConfig = new MailConfig();

                            $emailConfig->mailer->Subject = "@no reply reset you password";
                            $emailConfig->mailer->addAddress($email);

                            $emailConfig->mailer->Body = <<<END
                            
                            <h1>Reset your HarmoniHub password <h1/>
                            Click <a href="http://epita-nicolas.13h37.io/make_reset_password?token=$token">HERE</a> to reset your password.

                            END;
                            try{
                                $emailConfig->mailer->send();
                            }catch (Exception $e){
                                echo "le message n'a pas ete envoye error : {$email->ErrorInfo}";
                            }     
                        }
                        echo "Please check the massage in your email";

                    } else {
                       $erreurs[] = "Cette adress mail n'existe pas";
                        exit;
                    }
                } catch (PDOException $e) {
                    $erreurs[] = "Erreur lors de l'inscription : " . $e->getMessage();
                }
                exit();
                // session_destroy();
            }

        }
    }

    public function make_reset_password_process(): Renderer {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $connexion = Database::getConnection();
        
            $erreurs = [];
            $password = $_POST['password'];
            $password_confirmation = $_POST['password_confirmation'];
        
            // Vérifie tous les champs
            if (empty($password_confirmation) || empty($password)) {
                $erreurs[] = "Tous les champs sont obligatoires.";
            }
        
            if (!($password == $password_confirmation)) {
                $erreurs[] = "Tous les champs sont obligatoires.";
                die("Tous les champs sont obligatoires.");
            }
        
            $token = $_POST["token"];
            $token_hash = hash("sha256", $token);
        
            $sql = "SELECT * FROM users
                    WHERE reset_token_hash = ?";
        
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(1, $token_hash, \PDO::PARAM_STR);
            $stmt->execute();
        
            // Fetch the result as an associative array
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($user === false) {
                die("Token not found");
            }
        
            if (strtotime($user["reset_token_expires_at"]) <= time()) {
                die("Token has expired");
            }
        
            $password_hash = password_hash($password_confirmation, PASSWORD_DEFAULT);
        
            $sql = "UPDATE users
            SET password = ?,
                reset_token_hash = NULL,
                reset_token_expires_at = NULL
            WHERE id = ?";
        
            $stmt = $connexion->prepare($sql);
        
            // Bind the parameters using bindParam
            $stmt->bindParam(1, $password_hash, \PDO::PARAM_STR);
            $stmt->bindParam(2, $user["id"], \PDO::PARAM_INT); // Assuming id is an integer
        
            $stmt->execute();
        
            echo "Password updated. You can now login.";
        }
        return Renderer::make('Auth/login');
    }
}
?>
