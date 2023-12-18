<?php
    namespace Controllers;

    use Source\Database;
    use Source\Renderer;
    use \PDO;
    
    $token = $_GET["token"];
    echo $token;
    $token_hash = hash("sha256", $token);
    echo $token_hash;
    
    $connexion = Database::getConnection();
    
    $sql = "SELECT * FROM users
            WHERE reset_token_hash = ?";
    
    $stmt = $connexion->prepare($sql);
    
    // Bind the parameter using bindParam
    $stmt->bindParam(1, $token_hash, \PDO::PARAM_STR);
    
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result === false) {
        die("Token not found");
    }
    
    if (strtotime($result["reset_token_expires_at"]) <= time()) {
        die("Token has expired");
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du Mot de Passe</title>
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

        input {
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
<body>
    <div class="container">
        <h2>Réinitialisation du Mot de Passe</h2>
        <form action="make_reset_password" method="post">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">


            <label for="password">Nouveau Mot de Passe :</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirmation">Confirmer le Mot de Passe :</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">Réinitialiser le Mot de Passe</button>
        </form>
    </div>
</body>
</html>