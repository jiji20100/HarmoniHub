<?php

namespace Controllers;

use Source\Renderer;
use Models\User;

class HomeController
{
    public function index(): Renderer
    {
        //Example of using table users
        //$userModel = new User();
        //$users = $userModel->all();

        return Renderer::make('home');
    }
}

?>