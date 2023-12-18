<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
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

<body>

    <div class="image"></div>

    <div class="container pl-5 pr-5">
        <div class="row d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <!-- Vérifier et afficher les messages d'erreur ou de succès stockés en session -->
                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['error']; ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <div class="card text-light">
                    <div class="background"></div>
                    <div class="card-body p-5  text-center">
                        <div>
                            <h2 class="fw-bold mb-3 text-uppercase">Login</h2>

                            <!-- Formulaire de connexion avec fond blanc -->
                            <form action="/login" method="post" style="padding:10px">
                                <div class="form-outline form-light mb-4">
                                    <label for="email" class="form-label">Nom d'utilisateur</label>
                                    <input type="text" name="email" id="email" class="form-control form-control-lg" required>
                                </div>

                                <div class="form-outline form-light mb-4">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                            </form>

                            <p class="small mb-5 pb-lg-2"><a class="text-light" href="/reset_password">Forgot password?</a></p>
                        </div>

                        <div>
                            <p class="mb-0">Don't have an account? <a href="/register" class="text-light fw-bold">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

</body>

</html>
