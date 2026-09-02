<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class AuthController
{
    public function tela(): void
    {
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function autenticar(): void
    {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $model = new UsuarioModel();
        $usuario = $model->buscarPorEmail($email);

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            $_SESSION['erro'] = 'Ops, Email ou Senha inválidos!';
            header('Location: /JobsM/public/login');
            exit;
        }
        
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];

        header('Location: /JobsM/public/dashboard');
        exit;
    }

    public function sair(): void
    {
        session_destroy();
        header('Location: /JobsM/public/login');
        exit;
    }
}