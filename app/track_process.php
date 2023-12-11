<?php
session_start(); 

require_once('../config/config.php');

// Vérifie si le formulaire a été soumis
if (isset($_FILES['mp3_file'])) {
    $target_dir = "../files/"; // Modifier le chemin
    $target_file = $target_dir . basename($_FILES["mp3_file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifie si le fichier est bien un fichier MP3
    if ($fileType != "mp3") {
        $_SESSION['upload_message'] = 'Seuls les fichiers MP3 sont autorisés.';
        $_SESSION['upload_message_type'] = 'danger';
        header('Location: tracks.php');
        exit;
    }

    // Vérifie des erreurs d'upload
    if ($uploadOk == 0) {
        $_SESSION['upload_message'] = 'Le fichier n\'a pas pu être téléchargé.';
        $_SESSION['upload_message_type'] = 'danger';
        header('Location: tracks.php'); 
        exit;
    } else {
        if (move_uploaded_file($_FILES["mp3_file"]["tmp_name"], $target_file)) {
            $filename = basename($_FILES["mp3_file"]["name"]);
            $path = $target_file;
            $createdAt = date("Y-m-d H:i:s"); 

            try {
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Insère le fichier dans la table mp3_files
                $sql = "INSERT INTO mp3_files (name, path, created_at) VALUES (:name, :path, :created_at)";
                $stmt = $connexion->prepare($sql);
                $stmt->bindParam(":name", $filename);
                $stmt->bindParam(":path", $path);
                $stmt->bindParam(":created_at", $createdAt);
                $stmt->execute();

                $_SESSION['upload_message'] = 'Le fichier ' . $filename . ' a été téléchargé avec succès et enregistré dans la base de données.';
                $_SESSION['upload_message_type'] = 'success';
                header('Location: tracks.php'); 
                exit;
            } catch (PDOException $e) {
                $_SESSION['upload_message'] = 'Erreur de base de données : ' . $e->getMessage();
                $_SESSION['upload_message_type'] = 'danger';
                header('Location: tracks.php');
                exit;
            }
        } else {
            $_SESSION['upload_message'] = 'Une erreur s\'est produite lors du téléchargement du fichier.';
            $_SESSION['upload_message_type'] = 'danger';
            header('Location: tracks.php'); 
            exit;
        }
    }
} else {
    // Si le formulaire n'a pas été soumis
    $_SESSION['upload_message'] = 'Aucun fichier n\'a été téléchargé.';
    $_SESSION['upload_message_type'] = 'danger';
    header('Location: tracks.php');
    exit;
}
?>
