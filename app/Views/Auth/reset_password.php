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
                <?php endif;
                    if (isset($_SESSION['infos'])) : ?>
                    <div class="alert alert-info">
                        <?= $_SESSION['infos']; ?>
                        <?php unset($_SESSION['infos']); ?>
                    </div>
                <?php endif; ?>
                <div class="card text-light">
                    <div class="background"></div>
                    <div class="card-body p-5  text-center">
                        <div>
                            <h2 class="fw-bold mb-3 text-uppercase">Réinitialisation du Mot de Passe</h2>

                            <!-- Formulaire de connexion avec fond blanc -->
                            <form action="/reset_password" method="post" style="padding:10px">
                                <div class="form-outline form-light mb-4">
                                    <label for="email_fo_reset" class="form-label">Email</label>
                                    <input type="email" name="email_fo_reset" id="email_fo_reset" class="form-control form-control-lg" placeholder="Email..." required>
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Recover Password</button>
                            </form>

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
