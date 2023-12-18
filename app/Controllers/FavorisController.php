<?php

namespace Controllers;

use PDOException;
use Source\Renderer;
use Source\Database;
use Models\Favorite;

class FavorisController {

    public function favoris(): Renderer {
        $favorites = Favorite::getFavoritesByUserId($_SESSION['user_id']);
        return Renderer::make('favoris', ['favorites' => $favorites]);
       
    }


    public function addFavorite() {
        $userId = $_SESSION['user_id'];
        $trackId = $_POST['music_id'];
        Favorite::addFavorite($userId, $trackId);
        header('Location: /favoris');
        exit;
    }

    public function removeFavorite() {
        $userId = $_SESSION['user_id'];
        $trackId = $_POST['music_id'];
        Favorite::removeFavorite($userId, $trackId);
        header('Location: /favoris');
        exit;
    }
}

