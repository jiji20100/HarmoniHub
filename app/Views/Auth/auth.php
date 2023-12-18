<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Authentication Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .white-bg-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body style="background-image: url('https://wallpapers.com/images/hd/aesthetic-music-background-cvcbu6do9krpx1wc.jpg'); background-size: cover; background-position: center; margin: 0; padding: 0; overflow: hidden;">
    <div class="container pl-5 pr-5">
        <div class="row d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-white text-dark" style="border-radius: 1rem;">
                    <div class="card-body p-5  text-center">
                        <div>
                            <h2 class="fw-bold mb-3 text-uppercase">Page de Connexion</h2>

                            <!-- Formulaire de connexion avec fond blanc -->
                            <form action="/login" method="post" class="white-bg-form">
                               <a href="/login"><button class="btn btn-outline-dark btn-lg px-5 mb-3">Se connecter</button></a>
                               <a href="/register"><button class="btn btn-outline-dark btn-lg px-5 mb-3">S'inscrire</button></a>
                            </form>
                            <p class="small mb-5 pb-lg-2"><a class="text-dark" href="/reset_password">Forgot password?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
