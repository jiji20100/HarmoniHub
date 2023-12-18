<!DOCTYPE html>
<html lang="fr">
<head>
    <style>
        body {
            margin: 0; /* Réinitialise la marge du corps du document */
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 10px;
        }

        .app-name a {
            color: white;
            text-decoration: none;
            font-size: 20px; 
            font-weight: bold;
            padding: 5px 10px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            justify-content: flex-end; 
            flex-grow: 1; 
        }

        .nav-links li a {
            color: white;
            text-decoration: none;
            margin: 0 20px; 
            font-size: 18px; 
            padding: 10px 15px; 
        }

        .nav-links li {
            min-width: 120px; 
            text-align: center; 
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
                text-align: center;
            }

            .nav-links.active {
                display: flex;
            }
            .nav-links li a {
                padding: 15px 20px; /* Augmente le padding pour les appareils mobiles */
            }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="app-name">
            <a href="/home">HarmoniHub</a>
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="recherche.php">Rechercher</a></li>
            <li><a href="tracks.php">Mes Tracks</a></li>
            <li><a href="favorite.php">Mes Favoris</a></li>
            <li><a href="profile.php">Mon Profil</a></li>
            <li><form method="POST" action="logout.php">
                <button type="submit" class="logout-button">Déconnexion</button>
            </form></li>
        </ul>
    </nav>
   
</body>
</html>