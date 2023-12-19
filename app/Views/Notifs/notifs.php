<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!DOCTYPE html>
<head>
    <title>Notifications</title>
</head>
<style>
    .toast{
        position: fixed;
        top: 100px;
        right: 20px;
        width: 250px;
        height: 80px;
        background-color: #ffffff;
        border-radius: 7px;
        display: grid;
        grid-template-columns: 1.3fr 6fr 0.5fr;
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
    }

    .info{
        border-left: 3px solid #2F86EB;
    }
    .info p {
        padding: 0;
        margin: 0;
    }
    .inner-container p:first-child{
        color: #101020;
        font-weight: 600;
        font-size: 16px;
    }
    .inner-container p:last-child{
        font-size: 12px;
        font-weight: 400;
        color: #656565;
    }
    .toast button{
        position: absolute;
        top: 0;
        right: 0;
        width: 30px;
        height: 30px;
        border: none;
        outline: none;
        background-color: transparent;
        cursor: pointer;
    }
    .outer-container,.inner-container{
        align-self: center;
    } 
    .outer-container i{
        font-size: 35px;
    }
</style>
<body>

    <div class="toast info">
        <div class="outer-container">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="inner-container">
            <button>&times;</button>
            <p>Info</p>
            <p>New settings available on your account.</p>
        </div>
    </div>

    <div class="notifications" style="display:none">
        <h3>New Notification</h3>
        <div class="notif-content">
            <p>From</p>
            <p>Message</p>
        </div>
</body>



<script>
    let messages = <?php echo json_encode($messages); ?>;

    function parseJSON(data) {
        const jsonMatch = data.match(/\[.*\]/);

        if (jsonMatch && jsonMatch.length > 0) {
            const jsonString = jsonMatch[0];

            try {
                return JSON.parse(jsonString);
            } catch (error) {
                console.error('Error parsing JSON:', error);
            }
        } else {
            console.error('No JSON array found in the HTML string');
        }
    }

    function checkNewMessages() {

        fetch('/notifs/check_new_messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest' 
            }
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            data = parseJSON(data);
            console.log(data);

            if (data.length > messages.length) {
                // Affichez la notification ou effectuez d'autres actions nécessaires
                messages = data;
                alert('Nouveau message reçu!');
            }
        })
        .then(() => {
            // Répétez la vérification périodique
            setTimeout(checkNewMessages, 5000); // Vérifie toutes les 5 secondes (ajustez selon vos besoins)
        })
        .catch(error => console.log(error));
    }

    // Démarrez la vérification initiale
    //checkNewMessages();
</script>

