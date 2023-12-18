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
<?php include '../app/Resources/layout/navbar.php'; ?>
<body>

<div class="container">
    <div class="tracks-container">
        <h1>Mes Tracks</h1>
        <?php
            // Affichez la liste des fichiers
            foreach ($musics as $row) {
                $title = str_replace('_', ' ', $row['title']);
                echo '<div class="track">';
                echo '<h3>' . $title . '</h3>';
                echo '<audio id ="' . $row['title'] . '" controls>';
                echo '<source src="' . $row['file_path'] . '" type="audio/mpeg">';
                echo 'Votre navigateur ne supporte pas l\'élément audio.';
                echo '</audio>';
                echo '</div>';
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
                    foreach ($genres as $row) {
                        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
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
</script>

</body>
</html>