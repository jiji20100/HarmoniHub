<?php
    namespace Controllers;

    use Source\Database;
    use Source\Renderer;
    use \PDO;
    
    $token = $_GET["token"];
    echo $token;
    $token_hash = hash("sha256", $token);
    echo $token_hash;
    
    $connexion = Database::getConnection();
    
    $sql = "SELECT * FROM users
            WHERE reset_token_hash = ?";
    
    $stmt = $connexion->prepare($sql);
    
    // Bind the parameter using bindParam
    $stmt->bindParam(1, $token_hash, \PDO::PARAM_STR);
    
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result === false) {
        die("Token not found");
    }
    
    if (strtotime($result["reset_token_expires_at"]) <= time()) {
        die("Token has expired");
    }

?>


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
                            <h2 class="fw-bold mb-3 text-uppercase">Reset your password</h2>

                            <!-- Formulaire de connexion avec fond blanc -->
                            <form action="/make_reset_password" method="post" style="padding:10px">
                                <div class="form-outline form-light mb-4">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                                </div>

                                <div class="form-outline form-light mb-4">
                                    <label for="password_confirmation" class="form-label">Confirmer le Mot de passe</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" required>
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Reset Password</button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    

</body>

</html>
