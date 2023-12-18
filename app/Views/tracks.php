<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
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
        .music-list {
            width: 100%;
            max-width: 600px; 
            margin: 0 auto;
        }

        .track {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }

        .track-info {
            margin-right: 20px;
            width: 100%;
        }

        .track h3 {
            margin: 0 0 10px 0;
            font-size: 1em; 
        }

        audio {
            width: 100%; 
        }

        .edit-button, .delete-button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1em;
            margin-left: 10px;
            text-decoration: none;
            float: right;
        }

        .delete-button {
            color: red;
            padding-right: 1%;

        }

        .edit-button {
            color: green;
            padding-right: 3%;
        }

        
        .update-form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .update-form label {
            display: block;
            margin-bottom: 5px;
        }

        .update-form input[type="text"],
        .update-form select,
        .update-form input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .update-form button {
            padding: 10px 15px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .update-form button:hover {
            background-color: #0056b3;
        }
        .modal {
            display: none; /* Caché par défaut */
            position: fixed; /* Reste en place même lors du défilement de la page */
            z-index: 1000; /* S'affiche au-dessus des autres éléments */
            left: 0;
            top: 0;
            width: 100%; /* Largeur complète */
            height: 100%; /* Hauteur complète */
            overflow: auto; /* Permet le défilement si nécessaire */
            background-color: rgba(0, 0, 0, 0.4); /* Couleur de fond semi-transparente */
        }

        .modal-content {
            margin: 15% auto; /* 15% du haut de l'écran */
            width: 30%;
        }
        .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        margin-right: 0.7em;
        margin-top: 0.3em;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="tracks-container">
        <h1>Mes Tracks</h1>
        <?php
            if (isset($_SESSION['track_message'])) {
                $message_type = ($_SESSION['track_message_type'] == 'success') ? 'alert-success' : 'alert-danger';
                echo '<div class="alert ' . $message_type . '">' . $_SESSION['track_message'] . '</div>';
                unset($_SESSION['track_message']);
                unset($_SESSION['track_message_type']);
            }
            require_once('../app/config/config.php');
            try {
                $sql = "SELECT * FROM musics WHERE user_id = :user_id";
                $stmt = $connexion->prepare($sql);
                $stmt->bindParam(":user_id", $_SESSION['user_id']);
                $stmt->execute();
        
                $musics = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                echo '<div class="music-list">';
                foreach ($musics as $row) {
                    $title = str_replace('_', ' ', $row['title']);
                    echo '<div class="track">';
                    echo '<div class="track-info">';
                    echo '<h3>' . htmlspecialchars($title) . '<a href="#" class="edit-button" data-id="' . htmlspecialchars($row['id']) . '">&#x270E;</a><a href="#" class="delete-button" data-id="' . htmlspecialchars($row['id']) . '">&#x1F5D1;</a></h3>';
                    echo '<audio id ="' . htmlspecialchars($row['title']) . '" controls>';
                    echo '<source src="' . htmlspecialchars($row['file_path']) . '" type="audio/mpeg">';
                    echo 'Votre navigateur ne supporte pas l\'élément audio.';
                    echo '</audio>';
                    echo '</div>'; 
                    echo '</div>';
                    // Formulaires cachés pour la modification et la suppression
                    echo '<form method="POST" action="/delete_track" style="display: none;" id="delete-form-' . $row['id'] . '">';
                    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                    echo '</form>';
                    
                    echo '<form method="POST" action="/show_update_form_track" style="display: none;" id="update-form-' . $row['id'] . '">';
                    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                    echo '</form>';
                }
                echo '</div>'; 
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
            <label for="track_name">Nom :</label>
            <input type="text" name="track_name" id="track_name" required>
            <br>
            <label for="genre">Genre :</label>
            <select name="genre" id="genre">
                <?php
                    try {
                        $sql = "SELECT * FROM genres";
                        $stmt = $connexion->prepare($sql);
                        $stmt->execute(); 
                    
                        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                        foreach ($genres as $row) {
                            echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
                        }
                    } catch (PDOException $e) {
                        echo 'Erreur de base de données : ' . $e->getMessage();
                    }
                ?>
            </select>
            <br>
            <label for="featuring">featuring :</label>
            <input type="text" name="featuring" id="featuring">
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
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="updateFormContainer"></div>
        </div>
    </div>
</div>



<script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('mp3_file');
    const fileInfo = document.getElementById('file-info');
    const fileNameSpan = document.getElementById('file-name');
    const submitButton = document.getElementById('submit-button');
    const playButtons = document.querySelectorAll('.play-button');
    var audios = document.querySelectorAll('audio');


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


    audios.forEach(audio => {
        audio.addEventListener('play', function() {
            stopAllAudio(this.id);
        });
    });

    function stopAllAudio(exceptId) {
        audios.forEach(audio => {
            if(audio.id !== exceptId) {
                audio.pause();
                audio.currentTime = 0; // Remettre à zéro si vous le souhaitez
            }
        });
    }

    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', (e) => {
            const trackId = e.target.getAttribute('data-id');
            if (confirm('Êtes-vous sûr de vouloir supprimer ce track ?')) {
                document.getElementById('delete-form-' + trackId).submit();
            }
        });
    });

    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const trackId = e.target.getAttribute('data-id');

            fetch('/show_update_form_track', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest' 
                },
                body: 'id=' + trackId
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('updateFormContainer').innerHTML = html;
                document.getElementById('updateModal').style.display = 'block';
            });

        });
    });

    document.querySelector('.close').addEventListener('click', () => {
    document.getElementById('updateModal').style.display = 'none';
});
</script>

</body>
</html>