<?php

$router = new Router();

$router->get('/', "HomeController@index");


var_dump(explode('?', $_SERVER['REQUEST_URI']));

try {
    $router->resolve($_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    echo $e->getMessage();
}

?>