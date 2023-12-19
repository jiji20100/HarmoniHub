<head>
    <meta charset="UTF-8">
    <style>

        body {
            position: relative;
        }

        h1 {
            margin-bottom: 20px;
        }

        .l-bg-blue-dark {
            background: linear-gradient(to right, #373b44, #4286f4) !important;
            color: #fff;
        }

        .playlist-container, .playlist-music-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .playlist {
            padding: 0;
            margin: 0;
            width: 250px;
        }

        .music-item {
        width: 250px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 0;
        margin: 0;
        cursor: pointer;
        transition: background-color 0.3s;
        }

        .music-item:hover {
            background-color: #f0f0f0;
        }

        .music-item h3 {
            margin-bottom: 5px;
            color: #333;
        }

        .music-item p {
            color: #777;
        }

        .openUploadModal {
            position: fixed;
            top: 110px;
            right: 300px;
            z-index: 1000;
        }

        .container {
            position: relative;
            padding: 20px;
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
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .track {
            width: 400px;
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4f2c3df144.js" crossorigin="anonymous"></script>
</head>
<body>

    <script>
        function updatePlaylistMusic(playlistName, musicList) {
            const playlistMusicDiv = document.getElementById('playlist-music');
            playlistMusicDiv.innerHTML = '';

            let h2 = document.createElement('h2');
            h2.textContent = 'Musiques: ' + playlistName;
            document.getElementById('playlist-music').appendChild(h2);

            let musicDiv = document.createElement('div');
            musicDiv.classList.add('playlist-music-container');
            musicDiv.classList.add('row');
            musicDiv.classList.add('w-100');
            document.getElementById('playlist-music').appendChild(musicDiv);

            musicList.forEach((music) => {
                const musicItem = this.createMusicPlayer(music);
                this.hiddenForm(music, musicDiv);
                musicDiv.appendChild(musicItem);
            });
            
            setListeners();
        }

        function createMusicPlayer(music) {
            const track = document.createElement('div');
            track.classList.add('track');

            const trackInfo = document.createElement('div');
            trackInfo.classList.add('track-info');

            const titleHeading = document.createElement('h3');
            titleHeading.textContent = music.title;

            const editButton = document.createElement('a');
            editButton.href = '#';
            editButton.classList.add('edit-button');
            editButton.dataset.id = music.id;
            editButton.setAttribute('data-bs-toggle', 'modal');
            editButton.setAttribute('data-bs-target', '#updateModal');
            editButton.textContent = '\u270E';

            const deleteButton = document.createElement('a');
            deleteButton.href = '#';
            deleteButton.classList.add('delete-button');
            deleteButton.dataset.id = music.id;
            deleteButton.textContent = '\uD83D\uDDD1';

            titleHeading.appendChild(editButton);
            titleHeading.appendChild(deleteButton);

            const audioElement = document.createElement('audio');
            audioElement.id = music.id;
            audioElement.controls = true;

            const sourceElement = document.createElement('source');
            sourceElement.src = music.file_path;
            sourceElement.type = 'audio/mpeg';

            audioElement.appendChild(sourceElement);

            trackInfo.appendChild(titleHeading);
            trackInfo.appendChild(audioElement);

            track.appendChild(trackInfo);

            return track;
        }

        function hiddenForm(music, musicDiv) {
            // Formulaires cachés pour la modification et la suppression
            const deleteForm = document.createElement('form');
            deleteForm.method = 'POST';
            deleteForm.action = '/delete_track';
            deleteForm.style.display = 'none';
            deleteForm.id = 'delete-form-' + music.id;

            const deleteInput = document.createElement('input');
            deleteInput.type = 'hidden';
            deleteInput.name = 'id';
            deleteInput.value = music.id;

            deleteForm.appendChild(deleteInput);

            const updateForm = document.createElement('form');
            updateForm.method = 'POST';
            updateForm.action = '/show_update_form_track';
            updateForm.style.display = 'none';
            updateForm.id = 'update-form-' + music.id;

            const updateInput = document.createElement('input');
            updateInput.type = 'hidden';
            updateInput.name = 'id';
            updateInput.value = music.id;

            updateForm.appendChild(updateInput);
            musicDiv.appendChild(deleteForm);
            musicDiv.appendChild(updateForm);
        }

        function setListeners() {
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
                    });

                });
            });
        }
    </script>

    <div class="container">
        <button type="button" class="btn btn-primary openUploadModal" data-bs-toggle="modal" data-bs-target="#uploadModal">
            Upload new track
            <i class="far fa-upload mb-8" style="cursor:pointer; margin-left:10px"></i>
        </button>

        <div class="playlist-section col-12">
            <h1>Mes playlists</h1>
            <div class="playlist-container row w-100">
                <?php foreach ($musics['playlists'] as $playlist_name => $playlist) { ?>
                    
                <div class="playlist" onclick="updatePlaylistMusic(
                    <?php 
                    echo "'" . htmlspecialchars($playlist_name) . "', ";
                    echo htmlspecialchars(json_encode($playlist)); 
                    ?>)">
                    <div class="card l-bg-blue-dark">
                        <h3><?php echo htmlspecialchars($playlist_name); ?></h3>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Playlist</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    <span class="mr-2"><?php echo count($playlist); ?></span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php
                if (isset($_SESSION['track_message'])) {
                    $message_type = ($_SESSION['track_message_type'] == 'success') ? 'alert-success' : 'alert-danger';
                    echo '<div class="alert ' . $message_type . '">' . $_SESSION['track_message'] . '</div>';
                    unset($_SESSION['track_message']);
                    unset($_SESSION['track_message_type']);
                }  
            ?> 
            <div id="playlist-music" class="playlist-music-container row w-100">
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload new track</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Upload de fichiers MP3</h4>
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
                            <button id="submit-button" class="btn btn-success upload" type="submit" style="display: none;">
                                Upload
                                <i class="far fa-check mb-8" style="cursor:pointer; margin-left:10px"></i>
                            </button>                                
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
    <div id="updateModal" class="updateModal modal" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier le track</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="updateFormContainer"></div>
                </div>
            </div>
        </div>
    </div>

<script>
    updatePlaylistMusic("upload", <?php echo json_encode($musics['playlists']['upload']); ?>);

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
                audio.currentTime = 0; 
            }
        });
    }
</script>

