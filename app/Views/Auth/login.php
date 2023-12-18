<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body style="background-image: url('https://wallpapers.com/images/hd/aesthetic-music-background-cvcbu6do9krpx1wc.jpg'); background-size: cover; background-position: center; margin: 0; padding: 0; overflow: hidden;">

    <div class="container py-5">
        <!-- Vérifier et afficher les messages d'erreur ou de succès stockés en session -->
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>


        <?php if (isset($_SESSION['success'])) : ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="row d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-white text-dark" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <h2 class="fw-bold mb-2 text-uppercase">Login</h2>

                            <!-- Formulaire de connexion avec fond blanc -->
                            <form action="/login" method="post" class="white-bg-form">
                                <div class="form-outline form-dark mb-4">
                                    <label for="email" class="form-label">Nom d'utilisateur</label>
                                    <input type="text" name="email" id="email" class="form-control form-control-lg" required>
                                </div>

                                <div class="form-outline form-dark mb-4">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                                </div>

                                <button class="btn btn-outline-dark btn-lg px-5" type="submit">Login</button>
                            </form>

                            <p class="small mb-5 pb-lg-2"><a class="text-dark" href="/reset_password">Forgot password?</a></p>
                        </div>

                        <div>
                            <p class="mb-0">Don't have an account? <a href="/register" class="text-dark fw-bold">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Ajouter un style pour le fond blanc du formulaire */
        .white-bg-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>

</body>

</html>
