<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Administration</title>
    <style>
        .admin-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        .admin-button {
            margin: 0 10px;
            width: 60%;
            height: 30%;
            background-image: url('assets/img/background.png');
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="admin-buttons">
            <a href="/admin_users" class="btn btn-primary admin-button">Gestion des utilisateurs</a>
            <a href="/admin_tracks" class="btn btn-secondary admin-button">Gestion des tracks</a>
        </div>
    </div>
</body>
</html>
