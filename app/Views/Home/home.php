<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Site de Streaming</title>
    <style>
        
        .welcome-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            border: 2px solid #4CAF50; 
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            background-color: white; 
            max-width: 600px; 
            border-radius: 15px; 
        }

        .welcome-message h2 {
            color: #333;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .welcome-message p {
            color: #555;
            font-size: 18px;
        }

        .welcome-message button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['welcome_message'])): ?>
        <div class="welcome-message">
            <h2>Bienvenue sur votre site de streaming !</h2>
            <p>Profitez d'une expérience incroyable avec notre vaste collection de musiques. <br><br> Sur celui-ci, vous avez la possibilité d'ajouter vos propres sons et de les écouter. Vous pouvez aussi écouter ceux des autres en les recherchant dans la barre de recherche.</p>
            <button onclick="hideWelcomeMessage()">Ok</button>
        </div>
    <?php unset($_SESSION['welcome_message']); endif; ?>
</body>
</html>

<script>
    function hideWelcomeMessage() {
        document.querySelector('.welcome-message').style.display = 'none';
    }
</script>
    