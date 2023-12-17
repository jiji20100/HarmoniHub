<?php

namespace Source;

use Exceptions\RouteNotFoundException;
use Controllers\AuthController;
use Router\Router;
use Source\Session;
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

        $this->router->set('/', ['Controllers\AuthController', 'index'])->middleware(['Source\Session', 'redirectIfConnected']);
        $this->router->set('/index', ['Controllers\AuthController', 'index'])->middleware(['Source\Session', 'redirectIfConnected']);

        $this->router->set('/login', ['Controllers\AuthController', 'login'])->middleware(['Source\Session', 'redirectIfConnected']);
        $this->router->post('/login', ['Controllers\AuthController', 'login_process'])->middleware(['Source\Session', 'redirectIfConnected']);

        $this->router->set('/track', ['Controllers\TrackController', 'track'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/track', ['Controllers\TrackController', 'upload_track'])->middleware(['Source\Session', 'redirectIfNotConnected']);

        $this->router->set('/register', ['Controllers\AuthController', 'register'])->middleware(['Source\Session', 'redirectIfConnected']);
        $this->router->post('/register', ['Controllers\AuthController', 'register_process'])->middleware(['Source\Session', 'redirectIfConnected']);

        $this->router->set('/reset_password', ['Controllers\AuthController', 'reset_password'])->middleware(['Source\Session', 'redirectIfConnected']);
        $this->router->set('/logout', ['Controllers\AuthController', 'logout'])->middleware(['Source\Session', 'redirectIfNotConnected']);

        $this->router->set('/home', ['Controllers\HomeController', 'index'])->middleware(['Source\Session', 'redirectIfNotConnected']);
    }

    public function run()
    {
        session_start();

        // Routes qui nécessitent une authentification
        $protectedRoutes = ['/track', '/home', '/logout'];

        // Vérifier si l'utilisateur est connecté pour les routes protégées
        if (in_array($this->request_uri, $protectedRoutes) && !isset($_SESSION['user_id'])) {
            header("Location: /");
            exit;
        }

        //try {
        echo $this->router->handleRequest($this->request_uri, $this->request_method);
        /* } catch (RouteNotFoundException $e) {
            header("HTTP/2.0 404 Not Found");
            echo Renderer::make('Err/404');
         }*/
    }


}

?>