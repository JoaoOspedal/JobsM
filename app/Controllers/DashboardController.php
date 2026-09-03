<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\ServicoModel;

class DashboardController
{
    public function index(): void
    {
        Auth::checarLogado();

        $filtros = [
        'data_inicio' => $_GET['data_inicio'] ?? '',
        'data_fim' => $_GET['data_fim'] ?? '',
        'descricao' => $_GET['descricao'] ?? '',
        'status' => $_GET['status'] ?? '',
        'usuario_nome' => $_GET['usuario_nome'] ?? '',
        ];

        $model = new ServicoModel();
        $servicos = $model->listarComFiltros($filtros);
        $totalUsuario = $model->totalPorUsuario($_SESSION['usuario_id']);
        $pendentes = $model->pendentesPorUsuario($_SESSION['usuario_id']);

        require __DIR__ . '/../Views/dashboard/index.php';
    }
}