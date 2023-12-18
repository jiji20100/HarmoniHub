<?php

namespace Controllers;

use Source\Renderer;
use Models\User;

class AdminController
{
    public function index(): Renderer
    {
        return Renderer::make('Admin/admin');
    }
    public function admin_users_index(): Renderer
    {
        return Renderer::make('Admin/users');
    }
    public function admin_tracks_index(): Renderer
    {
        return Renderer::make('Admin/tracks');
    }
}

?>