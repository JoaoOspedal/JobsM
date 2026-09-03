<?php

namespace App\Controllers;

class HomeController
{
    public function index(): void
    {
        if (isset($_SESSION['usuario_id'])) {
            header('Location: /JobsM/public/dashboard');
        } else {
            header('Location: /JobsM/public/login');
        }
        exit;
    }
}