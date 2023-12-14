<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 50px;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #3498db;
            text-decoration: underline;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input{
            width: 95%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50; 
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049; 
        }
    </style>
</head>

<?php
// Vérifie si l'utilisateur est déjà connecté pour le rediriger
session_start(); 

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header('Location: home.php');
    exit;
}
?>

<body>
    <div class="container">
       
        <h2>Inscription</h2>
        <div class="erreur">
        <?php
            // Vérifie si des erreurs sont présentes
            if (!empty($erreurs)) {
                echo '<ul>';
                foreach ($erreurs as $erreur) {
                    echo '<li>' . $erreur . '</li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
        <form action="register_process.php" method="post">
            <label for="surname">Prenom:</label>
            <input type="text" id="surname" name="surname" required>

            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirmation">Confirmer le mot de passe:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">S'inscrire</button>
        </form>
        <br>
        <a href="login.php">Je possède déjà un compte</a>
    </div>
</body>
</html>
