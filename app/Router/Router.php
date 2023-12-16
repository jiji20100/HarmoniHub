<?php
namespace Router;

use Exceptions\RouteNotFoundException;

class Router {

    private array $routes = [];

    public function set(string $path, callable|array $action): void {
        $this->routes['GET ' . $path] = $action;
    }

    public function post(string $path, callable|array $action): void {
        $this->routes['POST ' . $path] = $action;
    }

    public function handleRequest(string $uri, string $requestType) {
        $path = explode('?', $uri)[0];
        $fullPath = $requestType . ' ' . $path;
        $action = $this->routes[$fullPath] ?? null;

        if (is_callable($action)) {
            return $action();
        }

        if (is_array($action)) {
            [$controllerName, $method] = $action;

            if (class_exists($controllerName) && method_exists($controllerName, $method)) {
                $controller = new $controllerName();
                return call_user_func_array([$controller, $method], []);
            }
        }

        throw new RouteNotFoundException("No route found for $fullPath", 404);
    }
}

?>
