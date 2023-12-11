<?php
include_once '../config/config.php';

$erreurs = array();

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];

    if (empty($surname) || empty($name) || empty($email) || empty($password) || empty($password_confirmation)) {
        $erreurs[] = "Tous les champs sont obligatoires.";
    } elseif ($password !== $password_confirmation) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }

    // Vérifier si l'utilisateur existe déjà dans la base de données
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $erreurs[] = "Cet e-mail est déjà utilisé. Veuillez en choisir un autre.";
    }

    if (empty($erreurs)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $insert_query = "INSERT INTO users (surname, name, email, password) VALUES (:surname, :name, :email, :password)";
        $insert_stmt = $connexion->prepare($insert_query);
        $insert_stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $insert_stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $insert_stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $insert_stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        if ($insert_stmt->execute()) {
            header('Location: login.php');
            exit();
        } else {
            $erreurs[] = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
        }
    }
}
$connexion = null;
?>
