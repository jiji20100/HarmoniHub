<!-- resources/views/auth/passwords/email.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de Réinitialisation du Mot de Passe</title>
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

        input{
            width: 95%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            background-color: #4caf50;
            width: 100%;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
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
        @if (session('status'))
            <div>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h2>Demande de Réinitialisation du Mot de Passe</h2>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <input type="email" name="email" placeholder="Votre adresse e-mail" required autofocus>
            <button type="submit">Envoyer le lien de réinitialisation</button>
        </form>
    </div>
</body>
</html>
