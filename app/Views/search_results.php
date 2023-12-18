<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de Recherche</title>
</head>
<body>
    <h1>Résultats de Recherche</h1>
    <?php if (!empty($musicList)) : ?>
        <ul>
            <?php foreach ($musicList as $music) : ?>
                <li>
                    <strong>Titre :</strong> <?= htmlspecialchars($music['title']); ?><br>
                    <strong>Artiste :</strong> <?= htmlspecialchars($music['artist']); ?><br>
                    <strong>Genre :</strong> <?= htmlspecialchars($music['genre']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Aucun résultat trouvé pour le genre recherché.</p>
    <?php endif; ?>
</body>
</html>
