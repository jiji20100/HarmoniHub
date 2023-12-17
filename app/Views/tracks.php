<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .upload-container {
            flex: 2;
            padding: 20px;
            border-left: 1px solid #ccc;
        }

        .tracks-container {
            flex: 1;
            padding: 20px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #dff0d8;
            border: 1px solid #c3e6cb;
            color: #333;
        }

        .alert-danger {
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            color: #a94442;
        }

        #drop-area {
            border: 2px dashed #ccc;
            padding: 20px;
        }

        #drop-area.active {
            border-color: #333;
        }

        #file-info {
            display: none;
        }
        body {
            text-align: left;
        }
    </style>
</head>
<body>
<?php include '../app/Resources/layout/navbar.php'?>

<div class="container">
    <div class="tracks-container">
        <h1>Mes Tracks</h1>
        <?php
            require_once('../app/config/config.php');
            try {
                // Sélectionnez les fichiers depuis la table musics en utilisant la connexion définie dans config.php
                $sql = "SELECT * FROM musics";
                $stmt = $connexion->query($sql);

                // Affichez la liste des fichiers
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $title = str_replace('_', ' ', $row['title']);
                    echo '<div class="track">';
                    echo '<h3>' . $title . '</h3>';
                    echo '<audio controls>';
                    echo '<source src="/files/' . $row['title'] . '" type="audio/mpeg">';
                    echo 'Votre navigateur ne supporte pas l\'élément audio.';
                    echo '</audio>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo 'Erreur de base de données : ' . $e->getMessage();
            }
        ?>
    </div>
    <div class="upload-container">
        <h1>Upload de fichiers MP3</h1>
        <?php
            if (isset($_SESSION['upload_message'])) {
                $message_type = ($_SESSION['upload_message_type'] == 'success') ? 'alert-success' : 'alert-danger';
                echo '<div class="alert ' . $message_type . '">' . $_SESSION['upload_message'] . '</div>';
                unset($_SESSION['upload_message']);
                unset($_SESSION['upload_message_type']);
            }
        ?>
        <form action="/track" method="POST" enctype="multipart/form-data">    
            <label for="mp3_file" style="cursor: pointer;">
                <div id="drop-area">
                    <h3 style ="text-align: center">+</h3>                    
                    <input type="file" name="mp3_file[]" id="mp3_file" accept=".mp3" style="display: none;" multiple>  
                </div>
            </label>
            <div id="file-info">
                <p>Nom du fichier : <span id="file-name"></span></p>
                <button class="upload" id="submit-button" type="submit" style="display: none;">Upload</button>
            </div>
        </form>

    </div>
</div>

<script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('mp3_file');
    const fileInfo = document.getElementById('file-info');
    const fileNameSpan = document.getElementById('file-name');
    const submitButton = document.getElementById('submit-button');
    const playButtons = document.querySelectorAll('.play-button');

    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('active');
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('active');
    });

    
    // Affichez les noms de tous les fichiers

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('active');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const fileNames = Array.from(files).map(file => file.name).join('; ');
            fileNameSpan.textContent = fileNames;
            fileInfo.style.display = 'block';
            submitButton.style.display = 'block';
        }
    });

    fileInput.addEventListener('change', () => {
        const files = fileInput.files;
        if (files.length > 0) {
            const fileNames = Array.from(files).map(file => file.name).join('; ');
            fileNameSpan.textContent = fileNames;
            fileInfo.style.display = 'block';
            submitButton.style.display = 'block';
        }
    });


    // Parcourez tous les boutons de lecture et ajoutez un gestionnaire d'événement au clic
    playButtons.forEach((button) => {
        button.addEventListener('click', () => {
            // Récupérez le chemin du fichier MP3 à partir de l'attribut data-src
            const audioSrc = button.getAttribute('data-src');

            // Créez un élément audio
            const audio = new Audio(audioSrc);

            // Jouez le fichier audio
            audio.play();
        });
    });
</script>

</body>
</html>