<?php

namespace App\Controllers;

use App\Core\Auth;

class DashboardController
{
    public function index(): void
    {
        Auth::checarLogado();

        echo 'Bem-vindo, ' . htmlspecialchars($_SESSION['usuario_nome']) . '!';
    }
}