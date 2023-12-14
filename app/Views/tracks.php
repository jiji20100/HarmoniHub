<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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
    </style>
</head>
<body>
<?php include '../layout/navbar.php'; ?>

<div class="container">
<h1>Upload de fichiers MP3</h1>
<?php
    session_start();
    if (isset($_SESSION['upload_message'])) {
        $message_type = ($_SESSION['upload_message_type'] == 'success') ? 'alert-success' : 'alert-danger';
        echo '<div class="alert ' . $message_type . '">' . $_SESSION['upload_message'] . '</div>';
        unset($_SESSION['upload_message']);
        unset($_SESSION['upload_message_type']);
    }
?>
    <form action="track_process.php" method="POST" enctype="multipart/form-data">
        <label for="mp3_file">Choisir un fichier MP3</label>
        <input type="file" name="mp3_file" id="mp3_file" accept=".mp3">
        <button class="upload" type="submit">Upload</button>
    </form>
</div>
</body>
</html>
