<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

use Router\Router;

require '../vendor/autoload.php';

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR);
define ('VIEWS', ROOT . "Views" . DIRECTORY_SEPARATOR);

$router = new Router();

$router->register('/', ['Controllers\AuthController', 'index']);
$router->register('/index', ['Controllers\AuthController', 'index']);

$router->register('/authentification/login', ['Controllers\AuthController', 'login']);
$router->register('/authentification/register', ['Controllers\AuthController', 'register']);
$router->register('/authentification/reset_password', ['Controllers\AuthController', 'reset_password']);
$router->register('/authentification/logout', ['Controllers\AuthController', 'logout']);

$router->register('/home', ['Controllers\HomeController', 'index']);

session_start();

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
        <link rel="stylesheet" href="app.css">
    </head>
</html>