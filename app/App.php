<?php

namespace Source;

use Exceptions\RouteNotFoundException;
use Router\Router;
use Source\Renderer;
use Source\Database;

class App {

    private Router $router;
    private string $request_uri;
    private string $request_method; 

    public function __construct(Router $router, string $request_uri, string $request_method)
    {
        $this->router = $router;
        $this->request_uri = $request_uri;
        $this->request_method = $request_method; 
    }

    public function initRoutes(): void
    {
        $this->router->set('/', ['Controllers\AuthController', 'index']);
        $this->router->set('/index', ['Controllers\AuthController', 'index']);

        $this->router->set('/login', ['Controllers\AuthController', 'login']);
        $this->router->post('/login', ['Controllers\AuthController', 'login_process']);

        $this->router->set('/register', ['Controllers\AuthController', 'register']);
        $this->router->post('/register', ['Controllers\AuthController', 'register_process']);
        $this->router->set('/reset_password', ['Controllers\AuthController', 'reset_password']);
        $this->router->set('/logout', ['Controllers\AuthController', 'logout']);

        $this->router->set('/home', ['Controllers\HomeController', 'index']);
    }

    public function run()
    {
        session_start();

        try {
            echo $this->router->handleRequest($this->request_uri, $this->request_method);
        } catch (RouteNotFoundException $e) {
            header("HTTP/2.0 404 Not Found");
            echo Renderer::make('Err/404');
        }
    }

}

?>