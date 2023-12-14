<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

use Router\Router;

require '../vendor/autoload.php';

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR);
define ('VIEWS', ROOT . "Views" . DIRECTORY_SEPARATOR);

$router = new Router();

$router->register('/', ['Controllers\HomeController', 'index']);


//$router->get('/', "HomeController@index");


//var_dump(explode('?', $_SERVER['REQUEST_URI']));

try {
    echo $router->resolve($_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    echo $e->getMessage();
}

?>




<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <link rel="stylesheet" href="resources/css/app.css">
    <style>

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
	    <a href="authentification/login.php"><button class="login">Se connecter</button></a>
        <a href="authentification/register.php"><button class="signup">S'inscrire</button></a>
	    <a href="authentification/reset_password.php">J'ai oublié mon mot de passe </a>
    </div>
</body>
</html>