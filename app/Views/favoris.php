<!-- favoris.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Mettez vos balises meta et styles ici -->
</head>
<body>

<div class="container">
    <div class="favoris-container">
        <h1>Mes Favoris</h1>
        <div class="favoris-list">
            <?php
            try {
                $favorites = $favorites ?? []; // Utilisez la syntaxe ?? pour éviter une erreur si la variable n'est pas définie

                foreach ($favorites as $favorite) {
                    echo '<div class="favori">';
                    echo '<div class="favori-info">';
                    echo '<h3>' . htmlspecialchars($favorite['title']) . '</h3>';
                    echo '<audio id ="' . htmlspecialchars($favorite['title']) . '" controls>';
                    echo '<source src="' . htmlspecialchars($favorite['file_path']) . '" type="audio/mpeg">';
                    echo 'Votre navigateur ne supporte pas l\'élément audio.';
                    echo '</audio>';
                    echo '</div>';
                    // Vous pouvez ajouter d'autres informations ici si nécessaire
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo 'Erreur de base de données : ' . $e->getMessage();
            }
            ?>
        </div>
    </div>
</div>

<!-- Mettez vos scripts JavaScript ici -->

</body>
</html>
