<?php

namespace Controllers;

use Source\Renderer;
use Source\Database;

class SearchController {
    
    public function showSearchForm(): Renderer
    {
        
        return Renderer::make('search-form');
    }

    public function search(): Renderer
    {
        $genre = $_GET['genre'] ?? ''; 
        $db = Database::getConnection();
        $query = "SELECT * FROM musics WHERE genre LIKE :genre";
        $stmt = $db->prepare($query);
        $genre = '%' . $genre . '%';
        $stmt->bindParam(':genre', $genre);
        $stmt->execute();
        $musicList = $stmt->fetchAll();
    
        return Renderer::make('search_results', ['musicList' => $musicList]);
    }

}
?>