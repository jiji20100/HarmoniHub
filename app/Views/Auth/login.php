<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    button {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 4px;
        background-color: #0056b3;
        color: white;
        cursor: pointer;
    }

    button:hover {
        background-color: #004494;
    }

    .alert {
        padding: 10px;
        background-color: #f44336;
        color: white;
        margin-bottom: 15px;
        border-radius: 4px;
        text-align: center;
    }

    a {
        color: #0056b3;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

    <div class="container">
        <!-- Vérifier et afficher les messages d'erreur ou de succès stockés en session -->
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <h2>Connexion</h2>
        
        <!-- Formulaire de connexion -->
        <form action="/login" method="post">
            <div class="form-group">
                <label for="email">Nom d'utilisateur</label>
                <input type="text" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit">Connexion</button>
        </form>

        <!-- Liens vers d'autres pages comme l'inscription ou la réinitialisation du mot de passe -->
        <p>Pas encore de compte ? <a href="/register">Inscrivez-vous</a></p>
        <p><a href="/reset_password">Mot de passe oublié ?</a></p>
    </div>

</body>
</html>