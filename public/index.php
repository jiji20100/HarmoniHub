<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

use Source\App;
use Router\Router;

require '../vendor/autoload.php';

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR);
define ('VIEWS', ROOT . "Views" . DIRECTORY_SEPARATOR);

$router = new Router();
$app = new App($router, $_SERVER['REQUEST_URI']);

$app->initRoutes();
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App</title>
        <link rel="stylesheet" href="app.css">
    </head>
    <?php $app->run(); ?>
</html>