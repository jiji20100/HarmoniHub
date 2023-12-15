<?php

namespace Source;

use Exceptions\RouteNotFoundException;
use Router\Router;
use Source\Renderer;

class App {

    public function __construct(private Router $router, private string $request_uri)
    {
        $this->router = $router;
        $this->request_uri = $request_uri;
    }

    public function initRoutes(): void
    {
        $this->router->set('/', ['Controllers\AuthController', 'index']);
        $this->router->set('/index', ['Controllers\AuthController', 'index']);

        $this->router->set('/authentification/login', ['Controllers\AuthController', 'login']);
        $this->router->set('/authentification/register', ['Controllers\AuthController', 'register']);
        $this->router->set('/authentification/reset_password', ['Controllers\AuthController', 'reset_password']);
        $this->router->set('/authentification/logout', ['Controllers\AuthController', 'logout']);

        $this->router->set('/home', ['Controllers\HomeController', 'index']);
    }

    public function run()
    {
        session_start();

        try {
            echo $this->router->get($this->request_uri);
        } catch (RouteNotFoundException $e) {
            header("HTTP/2.0 404 Not Found");
            echo Renderer::make('Err/404');
        }
    }

}

?>