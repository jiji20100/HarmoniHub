<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        .welcome-message {
            margin-bottom: 20px;
            color: #3498db;
            font-size: 24px;
        }

        .logout-button {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .logout-button:hover {
            background-color: #2874a6;
        }
    </style>
</head>
<body>
    <div class="welcome-message">
        Bienvenue, {{ Auth::user()->name }} !
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-button">Déconnexion</button>
    </form>
</body>
</html>
