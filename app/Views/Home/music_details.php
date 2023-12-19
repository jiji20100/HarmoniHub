<!-- music_details.php -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.6.8/plyr.js"></script>
    <style>
        .modal {
            display: none; 
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0, 0, 0, 0.4); 
        }

        .modal-content {
            margin: 15% auto; 
            width: 30% !important;
            padding: 20px;
            border-radius: 5px;
            background-color: #fff;
            text-align: center;
        }
        .close{
            
            text-align: right;
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

    <div class="container mt-5">
        <?php
        if (isset($detailsData['error'])) {
            echo '<p>' . $detailsData['error'] . '</p>';
        } else {
            $track = $detailsData['track'];
            $genres = $detailsData['genres'];
            $note = $detailsData['avg_note'];
            $comments = $detailsData['comment'];
            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<img src="https://www.myselfmonart.com/cdn/shop/files/tableau-dique-vinyle.png?v=1686643694&width=749" class="card-img-top" alt="Image">';
            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<h2>' . htmlspecialchars($track['title']) . '</h2>';
            echo '<p class="fs-5 text-muted">Artiste: ' . htmlspecialchars($track['artist']) . '</p>';
            echo '<p class="fs-5 text-muted">Genre: ' . htmlspecialchars($track['genre']) . '</p>';
            $noteFormatee = floatval($note['moyenne']);
            echo '<p class="fs-5 text-muted">Note: ' . htmlspecialchars($noteFormatee) . '/5</p>';
            echo '<div class="plyr__container">';
            echo '<audio id="audioPlayer" class="plyr">';
            echo '<source src="' . htmlspecialchars($track['file_path']) . '" type="audio/mpeg">';
            echo 'Votre navigateur ne supporte pas l\'élément audio.';
            echo '</audio>';
            echo '</div>';
            echo '<script>const player = new Plyr("#audioPlayer");</script>';
            echo '<div class="mt-4">';
            echo '<h3>Actions</h3>';
            if (isset($_SESSION['comment_and_note_message'])) {
                $message_type = ($_SESSION['comment_and_note_message_type'] == 'success') ? 'alert-success' : 'alert-danger';
                echo '<div class="alert ' . $message_type . '">' . $_SESSION['comment_and_note_message'] . '</div>';
                unset($_SESSION['comment_and_note_message']);
                unset($_SESSION['comment_and_note_message_type']);
            }
            // Formulaire pour ajouter un commentaire et donner une note
            echo '<form method="post" action="/add_comment_and_note">';

            echo '<div class="mb-3">';
            echo '<label for="comment" class="form-label">Ajouter un Commentaire</label>';
            echo '<textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>';
            echo '</div>';

            echo '<div class="mb-3">';
            echo '<label for="note" class="form-label">Donner une Note (entre 1 et 5)</label>';
            echo '<input type="number" class="form-control" id="note" name="note" min="1" max="5" required>';
            echo '</div>';

            echo '<input type="hidden" name="music_id" value="' . $_GET['id'] . '">';

            echo '<button type="submit" class="btn btn-primary">Ajouter Commentaire et Note</button> ';
            echo '</form>';
            if (isset($_SESSION['share_message'])) {
                $message_type = ($_SESSION['share_message_type'] == 'success') ? 'alert-success' : 'alert-danger';
                echo '<div class="alert ' . $message_type . '">' . $_SESSION['share_message'] . '</div>';
                unset($_SESSION['share_message']);
                unset($_SESSION['share_message_type']);
            }
            echo '<a href="#" style="color:#fff;text-decoration:none" class="btn btn-primary share-button" data-id=' . $track['id'] . '>Partager cette musique</a>';
            echo '<div class="mt-4">';
            echo '<h3>Commentaires</h3>';
            if (empty($comments)) {
                echo '<p>Aucun commentaire pour le moment.</p>';
            } else {
                echo '<div class="comments-list">';
                    foreach ($comments as $comment) {
                        echo '<div class="comment">';
                            echo '<p><strong>' . $comment['userId'] . ':</strong> ' . htmlspecialchars($comment['comment']) . '</p>';
                        echo '</div>';
                    }
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
    <div id="shareModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="shareFormContainer"></div>
        </div>
    </div>
</body>
<script>
    document.querySelectorAll('.share-button').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const track_id = e.target.getAttribute('data-id');
            fetch('/show_share_modal', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest' 
                },
                body: 'id=' + track_id
            })
            .then(response => response.text())
            .then(html => {
                
                console.log(track_id);
                document.getElementById('shareFormContainer').innerHTML = html;
                document.getElementById('shareModal').style.display = 'block';
            });

            });
        });

        document.querySelector('.close').addEventListener('click', () => {
            document.getElementById('shareModal').style.display = 'none';
        });
</script>
</html>
