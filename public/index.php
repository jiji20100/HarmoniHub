<?php

error_reporting(E_ALL ^ E_DEPRECATED);
ini_set("display_errors", 1);

use Source\App;
use Router\Router;

require '../vendor/autoload.php';

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR);
define ('VIEWS', ROOT . "Views" . DIRECTORY_SEPARATOR);

$router = new Router();
$app = new App($router, $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$app->initRoutes();

function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App</title>
        <link rel="stylesheet" href="app.css">
    </head>
    <?php
    $excludeNavbarOn = ['/login', '/register', '/reset_password', '/'];
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (!isAjaxRequest() && !in_array($currentPath, $excludeNavbarOn)) 
    {
        include '../app/Resources/layout/navbar.php'; 
    }
    $app->run(); 
    ?>
</html>
