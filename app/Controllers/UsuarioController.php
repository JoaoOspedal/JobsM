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
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if ($nome === '' || $email === '' || $senha === '') {
            $_SESSION['erro'] = 'Preencha nome, e-mail e senha.';
            header('Location: /JobsM/public/usuarios/novo');
            exit;
        }

        if (strlen($senha) < 6) {
            $_SESSION['erro'] = 'A senha precisa ter pelo menos 6 caracteres.';
            header('Location: /JobsM/public/usuarios/novo');
            exit;
        }

        try {
            $model = new UsuarioModel();
            $model->criar($nome, $email, $senha);
        } catch (\PDOException $e) {
            $_SESSION['erro'] = $e->getCode() === '23000'
                ? 'Esse e-mail já está cadastrado.'
                : 'Erro ao cadastrar usuário.';
            header('Location: /JobsM/public/usuarios/novo');
            exit;
        }

        $_SESSION['sucesso'] = 'Usuário cadastrado!';
        header('Location: /JobsM/public/login');
        exit;
    }
}