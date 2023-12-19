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
        $db = Database::getConnection();
    }

    public function initRoutes(): void
    {

        $this->router->get('/', ['Controllers\AuthController', 'index'])->middleware(['Source\Session', 'redirectIfConnected']);
        $this->router->get('/index', ['Controllers\AuthController', 'index'])->middleware(['Source\Session', 'redirectIfConnected']);

        $this->router->get('/login', ['Controllers\AuthController', 'login'])->middleware(['Source\Session', 'redirectIfConnected']);
        $this->router->post('/login', ['Controllers\AuthController', 'login_process'])->middleware(['Source\Session', 'redirectIfConnected']);

        $this->router->get('/register', ['Controllers\AuthController', 'register'])->middleware(['Source\Session', 'redirectIfConnected']);
        $this->router->post('/register', ['Controllers\AuthController', 'register_process'])->middleware(['Source\Session', 'redirectIfConnected']);

        $this->router->get('/reset_password', ['Controllers\AuthController', 'reset_password'])->middleware(['Source\Session', 'redirectIfConnected']);
        $this->router->post('/reset_password', ['Controllers\AuthController', 'send_reset_password'])->middleware(['Source\Session', 'redirectIfConnected']);
        $this->router->get('/make_reset_password', ['Controllers\AuthController', 'make_reset_password'])->middleware(['Source\Session', 'redirectIfConnected']);
        $this->router->post('/make_reset_password', ['Controllers\AuthController', 'make_reset_password_process'])->middleware(['Source\Session', 'redirectIfConnected']);

        $this->router->post('/logout', ['Controllers\AuthController', 'logout'])->middleware(['Source\Session', 'redirectIfNotConnected']);



        $this->router->get('/admin', ['Controllers\AdminController', 'index'])->middleware(['Source\Session', 'redirectIfNotConnected']);
    
        $this->router->get('/admin_tracks', ['Controllers\AdminController', 'admin_tracks_index'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/show_update_form_track_admin', ['Controllers\AdminController', 'show_update_form_track_admin'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/update_track_admin', ['Controllers\AdminController', 'update_track_admin'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/delete_track_admin', ['Controllers\AdminController', 'delete_track_admin'])->middleware(['Source\Session', 'redirectIfNotConnected']);

        $this->router->get('/admin_users', ['Controllers\AdminController', 'admin_users_index'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/show_update_form_user', ['Controllers\AdminController', 'show_update_form_user'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/update_user', ['Controllers\AdminController', 'update_user'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/delete_user', ['Controllers\AdminController', 'delete_user'])->middleware(['Source\Session', 'redirectIfNotConnected']);


        $this->router->get('/track', ['Controllers\TrackController', 'track'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/track', ['Controllers\TrackController', 'upload_track'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/show_update_form_track', ['Controllers\TrackController', 'show_update_form_track'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/update_track', ['Controllers\TrackController', 'update'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/delete_track', ['Controllers\TrackController', 'delete_track'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        

        $this->router->get('/notifs/check_new_messages', ['Controllers\NotifController', 'check_new_messages'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->get('/notifs/get_all_messages', ['Controllers\NotifController', 'get_all_messages'])->middleware(['Source\Session', 'redirectIfNotConnected']);

        $this->router->get('/home', ['Controllers\HomeController', 'index'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        
        $this->router->get("/music_details", ['Controllers\TrackController', 'show_details'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post("/show_share_modal", ['Controllers\TrackController', 'show_share_modal'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post("/share_track", ['Controllers\TrackController', 'share_track'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post("/add_comment_and_note", ['Controllers\TrackController', 'add_comment_and_note'])->middleware(['Source\Session', 'redirectIfNotConnected']);

        $this->router->get('/profile', ['Controllers\ProfileController', 'index'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->get('/profile/edit', ['Controllers\ProfileController', 'edit'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/profile/edit_process', ['Controllers\ProfileController', 'edit_process'])->middleware(['Source\Session', 'redirectIfNotConnected']);

        $this->router->get('/favorite', ['Controllers\FavorisController', 'favoris'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/addFavorite', ['Controllers\FavorisController', 'addFavorite'])->middleware(['Source\Session', 'redirectIfNotConnected']);
        $this->router->post('/removeFavorite', ['Controllers\FavorisController', 'removeFavorite'])->middleware(['Source\Session', 'redirectIfNotConnected']);
    
        $this->router->get('/rechercher', ['Controllers\SearchController', 'search'])->middleware(['Source\Session', 'redirectIfNotConnected']);

        $this->router->get('/search-form', ['Controllers\SearchController', 'showSearchForm'])->middleware(['Source\Session', 'redirectIfNotConnected']);
    }

    public function run()
    {
        try {
            echo $this->router->handleRequest($this->request_uri, $this->request_method);
        } catch (RouteNotFoundException $e) {
            header("HTTP/2.0 404 Not Found");
            echo Renderer::make('Errors/404');
         }
    }


}

?>