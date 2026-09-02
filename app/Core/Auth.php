<?php

namespace App\Core;

class Auth
{
    public static function checarLogado(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /JobsM/public/login');
            exit;
        }
    }
}