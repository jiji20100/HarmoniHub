<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Management</title>
    <!-- Include any additional styles or scripts as needed -->
</head>

<style>
    .notif {
        cursor: pointer;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        margin: 30px 50px;
        padding: 2rem;
        border-radius: 1rem;
    }
    .no_notif {
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        margin: 30px 50px;
        padding: 2rem;
        border-radius: 1rem;
    }
</style>


<body>

<h1 style="margin:20px;">Notification Management</h1>

<script>
    function redirect_to_music(id) {
        window.location.href = '/music_details?id=' + id;
    }
</script>

<?php
// Assuming $notifs is an array containing notifications
if (!empty($messages)) {
    foreach ($messages as $notif) {
        ?>
        <div class="notif" onclick="redirect_to_music(<?php echo $notif['music_id']['id']; ?>)">
            <p><strong>Music ID:</strong> <?php echo $notif['music_id']["title"]; ?></p>
            <p><strong>Message:</strong> <?php echo $notif['message']; ?></p>
        </div>
        <?php
    }
} else {
    echo '<div class="no_notif">';
    echo '<p><strong>No notifications available</strong></p>';
}
?>



</body>
</html>
