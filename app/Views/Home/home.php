<!-- home.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>HarmoniHub - Accueil</title>
    <style>
        /* Ajoutez votre propre style CSS ici si nécessaire */
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Affichage des 10 dernières pistes -->
    <div class="section">
        <h2 class="mb-4">Les 10 Dernières Pistes</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            <?php
            try {
                $lastTracks = \Models\Music::getLastTracks();
                foreach ($lastTracks as $track) {
                    echo '<div class="col mb-4">';
                    echo '<div class="card">';
                    echo '<img src="https://www.myselfmonart.com/cdn/shop/files/tableau-dique-vinyle.png?v=1686643694&width=749" class="card-img-top" alt="Image">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($track['title']) . '</h5>';
                    echo '<a href="music_details?id=' . $track['id'] . '" class="btn btn-primary">Détails</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } catch (\PDOException $e) {
                echo 'Erreur de base de données : ' . $e->getMessage();
            }
            ?>
        </div>
    </div>

    <!-- Affichage des 10 meilleures pistes notées -->
    <div class="section">
        <h2 class="mb-4">Les 10 Meilleures Pistes Notées</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            <?php
            try {
                $bestTracks = \Models\Music::getBestTracks();
                foreach ($bestTracks as $track) {
                    echo '<div class="col mb-4">';
                    echo '<div class="card">';
                    echo '<img src="https://www.myselfmonart.com/cdn/shop/files/tableau-dique-vinyle.png?v=1686643694&width=749" class="card-img-top" alt="Image">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($track['title']) . '</h5>';
                    echo '<a href="music_details?id=' . $track['id'] . '" class="btn btn-primary">Détails</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } catch (\PDOException $e) {
                echo 'Erreur de base de données : ' . $e->getMessage();
            }
            ?>
        </div>
    </div>

    <!-- Affichage des 10 pistes par genre -->
    <div class="section">
        <h2 class="mb-4">Les 10 Pistes par Genre</h2>
        <?php
        try {
            // Récupérez tous les genres
            $genres = \Models\Genre::getAllGenres();

            // Affichez les pistes pour chaque genre
            foreach ($genres as $genre) {
                // Récupérez les pistes pour le genre actuel
                $genreTracks = \Models\Music::getTracksByGenreId($genre['id']);

                // Affichez le genre seulement s'il y a des musiques associées
                if (!empty($genreTracks)) {
                    echo '<div class="genre-tracks mb-4">';
                    echo '<h3>' . htmlspecialchars($genre['name']) . '</h3>';
                    echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">';
                    foreach ($genreTracks as $track) {
                        echo '<div class="col mb-4">';
                        echo '<div class="card">';
                        echo '<img src="https://www.myselfmonart.com/cdn/shop/files/tableau-dique-vinyle.png?v=1686643694&width=749" class="card-img-top" alt="Image">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($track['title']) . '</h5>';
                        echo '<a href="music_details?id=' . $track['id'] . '" class="btn btn-primary">Détails</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
            }
        } catch (\PDOException $e) {
            echo 'Erreur de base de données : ' . $e->getMessage();
        }
        ?>
    </div>
</div>

</body>
</html>
