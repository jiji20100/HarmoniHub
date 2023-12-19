<?php

namespace Router;

use Source\Session;
use Exceptions\RouteNotFoundException;

class Router {

    private array $routes = [];
    private array $currentRoute = [];

    public function set(string $path, callable|array $action, string $requestType = 'GET'): self {
        $this->currentRoute = [
            'path' => $path,
            'action' => $action,
            'middlewares' => [],
            'requestType' => $requestType,
        ];

        return $this;
    }

    public function get(string $path, callable|array $action) {
        return $this->set($path, $action, 'GET');
    }

    public function post(string $path, callable|array $action) {
        return $this->set($path, $action, 'POST');
    }

    public function middleware(array $middlewares): self {
        $this->currentRoute['middlewares'][] = $middlewares;
        $this->routes[
            $this->currentRoute['requestType'] . ' ' . $this->currentRoute['path']
        ] = $this->currentRoute;

        return $this;
    }

    public function handleRequest(string $uri, string $requestType) {
        $path = explode('?', $uri)[0];
        $fullPath = $requestType . ' ' . $path;
        $route = $this->routes[$fullPath] ?? null;


        if ($route['middlewares']) {
            foreach ($route['middlewares'] as $middleware) {
                [$className, $method] = $middleware;
                if (class_exists($className) && method_exists($className, $method)) {
                    $class = new $className();
                    echo call_user_func_array([$class, $method], []);
                }
            }
        }

        $action = $route['action'];
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
