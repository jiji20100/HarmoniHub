<?php

namespace Controllers;

use Source\Renderer;
use Models\Message;
use Models\User;

class NotifController {
    public function index(): Renderer {
    }

    public function check_new_messages(): string {
        $messages = Message::getMessageByUserId($_SESSION['user_id']);
        $old_messages = $_SESSION['messages'] ?? [];
        $_SESSION['messages'] = $messages;
        
        if (count($old_messages) > 0) {
            if (count($messages) > count($old_messages)) {
                $messages = array_slice($messages, count($old_messages));
            } else {
                $messages = [];
            }
        }

        for ($i = 0; $i < count($messages); $i++) {
            $messages[$i]['from_id'] = User::getUserById($messages[$i]['from_id'])[0]['artist_name'];
        }

        $messages = json_encode($messages);
        return $messages;
    }

    public function get_all_messages(): string {
        $messages = Message::getMessageByUserId($_SESSION['user_id']);

        for ($i = 0; $i < count($messages); $i++) {
            $messages[$i]['from_id'] = User::getUserById($messages[$i]['from_id'])[0]['artist_name'];
        }

        return json_encode($messages);
    }
}


?>