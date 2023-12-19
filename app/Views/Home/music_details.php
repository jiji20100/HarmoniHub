<!-- music_details.php -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.6.8/plyr.js"></script>
</head>

<body>

    <div class="container mt-5">
        <?php
        if (isset($detailsData['error'])) {
            echo '<p>' . $detailsData['error'] . '</p>';
        } else {
            $track = $detailsData['track'];
            $genres = $detailsData['genres'];

            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<img src="https://www.myselfmonart.com/cdn/shop/files/tableau-dique-vinyle.png?v=1686643694&width=749" class="card-img-top" alt="Image">';
            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<h2>' . htmlspecialchars($track['title']) . '</h2>';
            
            // Style pour l'artiste
            echo '<p class="fs-5 text-muted">Artiste: ' . htmlspecialchars($track['artist']) . '</p>';
            
            // Style pour le genre
            echo '<p class="fs-5 text-muted">Genre: ' . htmlspecialchars($track['genre']) . '</p>';
            // ... (restez le même pour les autres détails)

            // Ajout d'un lecteur audio Plyr
            echo '<div class="plyr__container">';
            echo '<audio id="audioPlayer" class="plyr">';
            echo '<source src="' . htmlspecialchars($track['file_path']) . '" type="audio/mpeg">';
            echo 'Votre navigateur ne supporte pas l\'élément audio.';
            echo '</audio>';
            echo '</div>';

            // Initialisez Plyr
            echo '<script>const player = new Plyr("#audioPlayer");</script>';

            echo '<div class="mt-4">';
            echo '<h3>Actions</h3>';
            // Formulaire pour ajouter un commentaire et donner une note
            echo '<form method="post" action="add_comment_and_note.php">';

            // Zone de commentaire
            echo '<div class="mb-3">';
            echo '<label for="comment" class="form-label">Ajouter un Commentaire</label>';
            echo '<textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>';
            echo '</div>';

            // Zone de note
            echo '<div class="mb-3">';
            echo '<label for="note" class="form-label">Donner une Note (entre 1 et 5)</label>';
            echo '<input type="number" class="form-control" id="note" name="note" min="1" max="5" required>';
            echo '</div>';

            // Champ caché pour l'ID de la musique
            echo '<input type="hidden" name="music_id" value="' . $_GET['id'] . '">';

            // Bouton de soumission
            echo '<button type="submit" class="btn btn-primary">Ajouter Commentaire et Note</button>';

            echo '</form>';
            echo '</div>';
        }
        ?>
    </div>

</body>

</html>
