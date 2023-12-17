<?php

namespace Source;

class Session
{
    public static function isConnected(): bool
    {
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
            return true;
        }
        return false;
    }

    public static function redirectIfNotConnected(): void
    {
        if (!self::isConnected()) {
            header('Location: /');
            exit;
        }
    }

    public static function redirectIfConnected(): void
    {
        if (self::isConnected()) {
            header('Location: /home');
            exit;
        }
    }
}


?>