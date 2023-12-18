<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body style="background-image: url('https://wallpapers.com/images/hd/aesthetic-music-background-cvcbu6do9krpx1wc.jpg'); background-size: cover; background-position: center; margin: 0; padding: 0; overflow: hidden;">
    <div class="container py-5">
        <div class="erreur">
            <?php
                // Vérifie si des erreurs sont présentes
                if (!empty($erreurs)) {
                    echo '<ul>';
                    foreach ($erreurs as $erreur) {
                        echo '<li>' . $erreur . '</li>';
                    }
                    echo '</ul>';
                }
                ?>
        </div>
        <div class="row d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-white text-dark" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <h2 class="fw-bold mb-2 text-uppercase">Inscription</h2>

                            <!-- Formulaire de connexion avec fond blanc -->
                            <form action="/login" method="post" class="white-bg-form">
                                <div class="form-outline form-dark mb-4">
                                    <label for="email" class="form-label">Prenom</label>
                                    <input type="text" name="surname" id="surname" class="form-control form-control-lg" required>
                                </div>

                                <div class="form-outline form-dark mb-4">
                                    <label for="password" class="form-label">Nom</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-lg" required>
                                </div>

                                <div class="form-outline form-dark mb-4">
                                    <label for="email" class="form-label">E-Mail</label>
                                    <input type="email" name="email" id="email" class="form-control form-control-lg" required>
                                </div>

                                <div class="form-outline form-dark mb-4">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                                </div>

                                <div class="form-outline form-dark mb-4">
                                    <label for="password" class="form-label">Confirmer le mot de passe</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" required>
                                </div>


                                <button class="btn btn-outline-dark btn-lg px-5" type="submit">S'inscrire</button>
                            </form>
                        </div>

                        <div>
                            <p class="mb-0">Déjà un compte? <a href="/login" class="text-dark fw-bold">Se connecter</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
