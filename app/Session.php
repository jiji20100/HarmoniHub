<?php

namespace Source;

use Models\User;

class Session
{
    public static function isConnected(): bool
    {
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {

            $user = User::getUserById($_SESSION['user_id']);
            if (!$user) {
                unset($_SESSION['is_logged_in']);
                return false;
            }
            return true;
        }
        return false;
    }

    public static function redirectIfNotConnected(): void
    {
        if (!self::isConnected()) {
            // header('Location: /');
            exit;
        }
    }

    public static function redirectIfConnected(): void
    {
        if (self::isConnected()) {
            // header('Location: /home');
            exit;
        }
    }
}


?>