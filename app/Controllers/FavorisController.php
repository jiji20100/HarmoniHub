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

    public function add_favorite() {
        if (isset($_POST['id'])) {
            $userId = $_SESSION['user_id'];
            $trackId = $_POST['id'];
            $result = Favorite::addFavorite($userId, $trackId);
        } else {
            echo 'no_music_id'; // Si aucun ID de musique n'est fourni
        }
        header('Location: /favorite');
        exit; // Arrête l'exécution du script
    }


    public function addFavorite() {
        if (isset($_POST['music_id'])) {
            $userId = $_SESSION['user_id'];
            $trackId = $_POST['music_id'];
    
            if (!Favorite::isFavorite($userId, $trackId)) {
                Favorite::addFavorite($userId, $trackId);
                // Vous pouvez choisir de rediriger ou d'envoyer une réponse ici
                // Par exemple:
                echo 'success';
            } else {
                echo 'already_favorite';
            }
        } else {
            echo 'no_music_id';
        }
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

