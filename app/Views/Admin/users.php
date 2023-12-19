<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <style>
        body {
            text-align: left;
        }
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
        }
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .update-form label {
            display: block;
            margin: 10px 0; 
        }

        .update-form input,
        .update-form button {
            width: 95%;
            padding: 8px;
            margin: auto; 
        }

        .update-form button {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .update-form button:hover {
            background: #0056b3;
        }
        .delete-button {
            color: red;
            padding-right: 1%;

        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Gestion des Utilisateurs</h2>
        <p>Utilisez ce tableau pour gérer les utilisateurs de l'application.</p>
        <?php
        if (isset($_SESSION['user_message'])) {
                $message_type = ($_SESSION['user_message_type'] == 'success') ? 'alert-success' : 'alert-danger';
                echo '<div class="alert ' . $message_type . '">' . $_SESSION['user_message'] . '</div>';
                unset($_SESSION['user_message']);
                unset($_SESSION['user_message_type']);
            }
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Nom d'artiste</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Date de création</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['surname']) ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['artist_name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role_id']) ?></td>
                <td><?= htmlspecialchars($user['created_at']) ?></td>
                <td>
                    <a href="#" class="edit-button" data-id=<?=$user['id']?>>&#x270E;</a>
                    <a href="#" class="delete-button" data-id=<?=$user['id']?>>&#x1F5D1;</a>
                    <form method="POST" action="/delete_user" style="display: none;" id=<?="delete-form-" . $user['id']?>>
                        <input type="hidden" name="id" value=<?=$user['id']?>>
                    </form>
                    
                </td>
            </tr>
        <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="updateFormContainer"></div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script>
        $(document).ready(function() {
            $('.table').DataTable({});
        });

        document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const user_id = e.target.getAttribute('data-id');

            fetch('/show_update_form_user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest' 
                },
                body: 'id=' + user_id
            })
            .then(response => response.text())
            .then(html => {
                console.log(html);
                document.getElementById('updateFormContainer').innerHTML = html;
                document.getElementById('updateModal').style.display = 'block';
            });

            });
        });

        document.querySelector('.close').addEventListener('click', () => {
            document.getElementById('updateModal').style.display = 'none';
        });

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', (e) => {
                const trackId = e.target.getAttribute('data-id');
                if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                    document.getElementById('delete-form-' + trackId).submit();
                }
            });
        });

    </script>
</body>
</html>
