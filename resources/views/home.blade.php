<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
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
	    <a href="{{ route('login') }}"><button class="login">Se connecter</button></a>
        <a href="{{ route('register') }}"><button class="signup">S'inscrire</button></a>
	    <a href="{{ route('password.request') }}">J'ai oublié mon mot de passe </a>
    </div>
</body>
</html>
