
<!DOCTYPE html>
<html lang="fr">
<head>
    <style>
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
            align-items: center;
            list-style: none;
            display: flex;
            justify-content: flex-end; 
            flex-grow: 1; 
        }

        .nav-links li a {
            align-items: center;
            color: white;
            text-decoration: none;
            margin: 20px; 
            font-size: 18px; 
            padding: 10px 15px; 
        }

        .nav-links li {
            align-items: center;
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
            <li><a href="/recherche">Rechercher</a></li>
            <li><a href="{{ route('upload.form') }}">Mes Tracks</a></li>
            <li><a href="/favoris">Mes Favoris</a></li>
            <li><a href="/profil">Mon Profil</a></li>
            <li><form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Déconnexion</button>
            </form></li>
        </ul>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <!-- Pied de page, Scripts JS, etc. -->
</body>
</html>
