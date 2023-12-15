<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="">
    <title>Authentication Page</title>
    <style>
        .container {
            max-width: 400px;
            margin: calc(50vh - 150px) auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button.signup {
            background-color: #4caf50;
            color: #fff;
        }

        button.login {
            background-color: #3498db;
            color: #fff;
        }

        .container a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Page de Connexion</h2>
	    <a href="authentification/login"><button class="login">Se connecter</button></a>
        <a href="authentification/register"><button class="signup">S'inscrire</button></a>
	    <a href="authentification/reset_password">J'ai oublié mon mot de passe </a>
    </div>
</body>
</html>
