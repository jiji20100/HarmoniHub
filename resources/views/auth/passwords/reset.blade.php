<!-- resources/views/auth/passwords/reset.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du Mot de Passe</title>
    <style>
           body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .reset-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            text-align: center;
        }

        input, button {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="reset-form">
        <h2>Réinitialisation du Mot de Passe</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="email" name="email" placeholder="Votre adresse e-mail" value="{{ $email ?? old('email') }}" required autofocus>
            <input type="password" name="password" placeholder="Nouveau mot de passe" required>
            <input type="password" name="password_confirmation" placeholder="Confirmez le mot de passe" required>
            <button type="submit">Réinitialiser le Mot de Passe</button>
        </form>
    </div>
</body>
</html>
