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
}

?>