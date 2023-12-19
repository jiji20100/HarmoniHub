<?php

session_start();
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
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <title>App</title>
        <link rel="stylesheet" href="app.css">
    </head>
    <?php
    $excludeNavbarOn = ['/login', '/register', '/reset_password', '/'];
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (!isAjaxRequest() && !in_array($currentPath, $excludeNavbarOn)) 
    {
        include '../app/Resources/layout/navbar.php'; 
        include '../app/Resources/layout/notifs.php';
    }
    $app->run(); 
    ?>
</html>