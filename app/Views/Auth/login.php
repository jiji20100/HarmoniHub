<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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

        .success-message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            background-color: #ccffcc;
            color: #006400;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <form method="POST" action="../app/home.php">
            <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Se connecter</button>
        </form>
        <br>
        <a href="register.php">Je n'ai pas encore de compte</a>
        <br>
        <br>
        <a href="reset_password.php">J'ai oublié mon mot de passe</a>
    </div>
</body>
</html>
