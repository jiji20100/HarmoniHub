<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            position: relative;
            background-color: #000;
        }

        .image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('assets/img/background.png');
            opacity: 0.9;
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .card {
            position: relative;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: transparent;
            border-radius: 1rem;
            overflow: hidden;
        }

        .card .background {
            -webkit-backdrop-filter: blur(15px); /* assure la compatibilité avec safari */
            backdrop-filter: blur(15px);
            background-color: rgba(182, 182, 182, 0.1);
            z-index: 1;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
        }

        .card-body {
            position: relative;
            z-index: 2;
        }

        /* Ajouter un style pour le fond blanc du formulaire */
        .white-bg-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="row d-flex justify-content-center align-items-center">
    
    <div class="image"></div>

    <div class="container pl-5 pr-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                <div class="container">
                    <?php if (isset($_SESSION['errors'])) : ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['errors']; ?>
                            <?php unset($_SESSION['errors']); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card text-light">
                    <div class="background"></div>
                    <div class="card-body p-5 text-center">
                        <div>
                            <h2 class="fw-bold mb-2 text-uppercase">Inscription</h2>

                            <!-- Formulaire de connexion avec fond blanc -->
                            <form action="/register" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-outline form-light mb-4">
                                            <label for="email" class="form-label">Prenom</label>
                                            <input type="text" name="surname" id="surname" class="form-control form-control-lg" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-outline form-light mb-4">
                                            <label for="password" class="form-label">Nom</label>
                                            <input type="text" name="name" id="name" class="form-control form-control-lg" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-outline form-light mb-4">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" id="username" class="form-control form-control-lg">
                                </div>
                                <div class="form-outline form-light mb-4">
                                    <label for="email" class="form-label">E-Mail</label>
                                    <input type="email" name="email" id="email" class="form-control form-control-lg" required>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-outline form-light mb-4">
                                            <label for="password" class="form-label">Mot de passe</label>
                                            <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-outline form-light mb-4">
                                            <label for="password" class="form-label">Confirmer le mot de passe</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" required>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">S'inscrire</button>
                            </form>
                        </div>

                        <div>
                            <p class="mb-0">Déjà un compte? <a href="/login" class="text-light fw-bold">Se connecter</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
