<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class UsuarioController
{
    public function index(): void
    {
        $model = new UsuarioModel();
        $usuarios = $model->listarTodos();

        require __DIR__ . '/../Views/usuarios/index.php';
    }

    public function novo(): void
    {
        require __DIR__ . '/../Views/usuarios/novo.php';
    }
    
    public function criar(): void
    {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';

        $model = new UsuarioModel();
        $model->criar($nome, $email);

        header('Location: /JobsM/public/usuarios');
        exit;
    }
}