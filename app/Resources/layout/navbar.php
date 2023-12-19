<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            margin: 0; /* Réinitialise la marge du corps du document */
        }
        .navbar {
            position: relative;
            margin: 0;
            background-image: url('assets/img/background.png');
        }

        .navbar-background {
            -webkit-backdrop-filter: blur(15px); /* assure la compatibilité avec safari */
            backdrop-filter: blur(15px);
            background-color: rgba(100, 100, 100, 0.2);
            z-index: 1;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
        }

        .navbar-content {
            position: relative;
            display: flex;
            width: calc(100% - 80px);
            justify-content: space-between;
            align-items: center;
            color: black;
            padding: 10px;
            z-index: 2;
            margin: 0 40px;
        }

        .app-name a {
            color: white;
            text-decoration: none;
            font-size: 20px; 
            font-weight: bold;
            padding: 5px 10px;
            transition: 0.1s;
        }

        .app-name a:hover {
            color: #f44336;
        }

        .nav-links {
            list-style: none;
            display: flex;
            justify-content: flex-end; 
            padding: 0;
            margin: 10px;
            gap: 10px;
        }

        .nav-links li {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            min-width: 120px; 
            text-align: center; 
        }

        .nav-links li a {
            color: white;
            text-decoration: none;
            font-size: 18px; 
        }

        .nav-links li a::after {
            position: absolute;
            content: '';
            width: 0;
            height: 2px;
            background-color: #f44336;
            display: block;
            margin: auto;
            margin-top: 15px;
            left: 0;
            transition: 0.5s;
        }

        .nav-links li a:hover {
            color: #f44336;
        }

        .nav-links li a:hover::after {
            width: 100%;
        }

        .nav-links li a.active {
            color: #f44336;
        }

        .nav-links li a.active::after {
            width: 100%;
        }

        .logout-button {
            background-color: transparent;
            color: white;
            border: 1px solid white;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .logout-button:hover {
            background-color: #f44336;
            border: 1px solid #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar" style="padding:0">
        <div class="navbar-background"></div>
        <div class="navbar-content">
            <div class="app-name">
                <img src="assets/img/logo.png" alt="logo" style="width: 50px; height: 50px; margin-right: 10px">
                <a href="/home" style="text-decoration:none">HarmoniHub</a>
            </div>
            <ul class="nav-links" id="navLinks" style="padding:0">
                <li><a href="/search-form">Rechercher</a></li>
                <li><a href="/track">Mes Tracks</a></li>
                <li><a href="/favorite">Mes Favoris</a></li>
                <li><a href="/profile">Mon Profil</a></li>
                <li><form action="/logout" method="POST" style="margin: 0"><button class="logout-button">Se déconnecter</button></form></li>
            </ul>
        </div>
    </nav>
</body>
</html>