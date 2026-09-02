<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\ServicoModel;

class DashboardController
{
    public function index(): void
    {
        Auth::checarLogado();

        $model = new ServicoModel();
        $servicos = $model->listarTodos();
        $totalUsuario = $model->totalPorUsuario($_SESSION['usuario_id']);
        $pendentes = $model->pendentesPorUsuario($_SESSION['usuario_id']);

        require __DIR__ . '/../Views/dashboard/index.php';
    }
}