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
        border-left: 3px solid #2F86EB;
    }

    .toast p {
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

    .toast button {
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
    .toast button.open{
        right: 40px;
    }
    .toast button.close{
        right: 0;
    }
    .outer-container,.inner-container{
        align-self: center;
    } 
    .outer-container i{
        font-size: 35px;
    }
</style>
<body>
<div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div id="modal-content-messages" class="modal-body">
      </div>
    </div>
  </div>
</div>
</body>

<script>
    let messages = [];

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
            method: 'GET',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest' 
            }})
        .then(response => response.text())
        .then(data => {
            data = parseJSON(data);

            console.log(data);

            if (data.length > 0) {
                createToast(data[data.length - 1].from_id, data[data.length - 1].message);
            }
        })
        .then(() => {
            setTimeout(checkNewMessages, 5000);
        })
        .catch(error => console.log(error));
    }

    function getAllMessages() {
        console.log('getting all messages');
        fetch('/notifs/get_all_messages', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest' 
            }})
        .then(response => response.text())
        .then(data => {
            data = parseJSON(data);
            createModalContent(data);
            console.log(data);
        })
    }

    function createModalContent(data) {
        console.log(data);

        const modalContent = document.getElementById('modal-content-messages');
        modalContent.innerHTML = '';

        data.forEach(message => {
            const messageElement = document.createElement('div');
            messageElement.classList.add('message');

            const from = document.createElement('p');
            from.innerHTML = message.from_id;

            const messageContent = document.createElement('p');
            messageContent.innerHTML = message.message;

            messageElement.appendChild(from);
            messageElement.appendChild(messageContent);
            messageElement.appendChild(document.createElement('hr'));

            messageElement.addEventListener('click', () => {
                window.location.href = '/music_details?id=' + message.music_id;
            });

            modalContent.appendChild(messageElement);
        });
    }

    function createToast(from, message) {
        const toast = document.createElement('div');
        toast.classList.add('toast');
        toast.classList.add('show');

        const outerContainer = document.createElement('div');
        outerContainer.classList.add('outer-container');

        const icon = document.createElement('i');
        icon.classList.add('fas');
        icon.classList.add('fa-info-circle');

        const innerContainer = document.createElement('div');
        innerContainer.classList.add('inner-container');

        const closeButton = document.createElement('button');
        closeButton.classList.add('close');
        closeButton.innerHTML = '&times;';
        closeButton.addEventListener('click', () => {
            toast.remove();
        });

        const openButton = document.createElement('button');
        openButton.classList.add('open');
        openButton.setAttribute('data-bs-toggle', 'modal');
        openButton.setAttribute('data-bs-target', '#notifModal');
        openButton.innerHTML = '<b>open</b>';
        openButton.addEventListener('click', () => {
            toast.remove();
            getAllMessages();
        });

        const title = document.createElement('p');
        title.innerHTML = from;

        const messageElement = document.createElement('p');
        messageElement.innerHTML = message;

        innerContainer.appendChild(openButton);
        innerContainer.appendChild(closeButton);
        innerContainer.appendChild(title);
        innerContainer.appendChild(messageElement);

        outerContainer.appendChild(icon);

        toast.appendChild(outerContainer);
        toast.appendChild(innerContainer);

        console.log(toast);

        document.body.appendChild(toast);
    }

    // Démarrez la vérification initiale
    checkNewMessages();
</script>
