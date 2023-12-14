<?php

namespace Router;

use Exceptions\RouteNotFoundException;

class Router {

    private array $routes = []; 

    public function register(string $path, collable|array $action): void {
        $this->routes[$path] = $action;
    }


    public function resolve(string $uri) {
        $path = explode('?', $uri)[0];
        $action = $this->routes[$path] ?? null;

        if (is_callable($action)) {
            return $action();
        }

        if (is_array($action)) {
            [$controllerName, $method] = $action;

            if (class_exists($controllerName) && method_exists($controllerName, $method)) {
                $controller = new $controllerName();
                return call_user_func_array([$controller, $method], []);
                echo "here";
            }
            echo "here";
        }
        echo "here";

        throw new RouteNotFoundException();
    }
}
?>