<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\ServicoModel;
use App\Models\UsuarioModel;

class ServicoController
{
    public function novo(): void
    {
        Auth::checarLogado();
        require __DIR__ . '/../Views/servicos/novo.php';
    }

    public function criar(): void
    {
        Auth::checarLogado();

        $descricao = trim($_POST['descricao'] ?? '');
        $valor = $_POST['valor'] ?? '';

        if ($descricao === '' || $valor === '' || !is_numeric($valor) || (float) $valor <= 0) {
            $_SESSION['erro'] = 'Falha ao cadastrar o serviço. Verifique a descrição e o valor.';
            header('Location: /JobsM/public/dashboard');
            exit;
        }

        try {
            $model = new ServicoModel();
            $model->criar($descricao, (float) $valor, $_SESSION['usuario_id']);
            $_SESSION['sucesso'] = 'Serviço cadastrado com sucesso!';
        } catch (\PDOException $e) {
            $_SESSION['erro'] = 'Falha ao cadastrar o serviço. Tente novamente.';
        }

        header('Location: /JobsM/public/dashboard');
        exit;
    }

    public function editar(): void
    {
        Auth::checarLogado();

        $id = (int) ($_GET['id'] ?? 0);
        $model = new ServicoModel();
        $servico = $model->buscarPorId($id);

        if (!$servico) {
            $_SESSION['erro'] = 'Serviço não encontrado.';
            header('Location: /JobsM/public/dashboard');
            exit;
        }

        require __DIR__ . '/../Views/servicos/editar.php';
    }

    public function atualizar(): void
    {
        Auth::checarLogado();

        $id = (int) ($_GET['id'] ?? 0);
        $descricao = trim($_POST['descricao'] ?? '');
        $valor = $_POST['valor'] ?? '';

        if ($descricao === '' || $valor === '' || !is_numeric($valor) || (float) $valor <= 0) {
            $_SESSION['erro'] = 'Falha ao atualizar o serviço. Verifique a descrição e o valor.';
            header('Location: /JobsM/public/dashboard');
            exit;
        }

        $model = new ServicoModel();
        $model->atualizar($id, $descricao, (float) $valor);
        $_SESSION['sucesso'] = 'Serviço atualizado com sucesso!';

        header('Location: /JobsM/public/dashboard');
        exit;
    }

    public function excluir(): void
    {
        Auth::checarLogado();

        $id = (int) ($_GET['id'] ?? 0);
        $model = new ServicoModel();
        $model->excluir($id);

        $_SESSION['sucesso'] = 'Serviço excluído.';
        header('Location: /JobsM/public/dashboard');
        exit;
    }

    public function finalizar(): void
    {
        Auth::checarLogado();

        $id = (int) ($_GET['id'] ?? 0);
        $model = new ServicoModel();
        $servico = $model->buscarPorId($id);

        if (!$servico) {
            $_SESSION['erro'] = 'Serviço não encontrado.';
            header('Location: /JobsM/public/dashboard');
            exit;
        }

        $model->finalizar($id);

        $servicoAtualizado = $model->buscarPorId($id);
        $this->enviarEmailFinalizacao($servicoAtualizado);

        $_SESSION['sucesso'] = 'Serviço finalizado com sucesso!';
        header('Location: /JobsM/public/dashboard');
        exit;
    }

    private function enviarEmailFinalizacao(array $servico): void
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->buscarPorId($servico['usuario_id']);

        if (!$usuario) {
            return;
        }

        $assunto = 'Serviço finalizado: ' . $servico['descricao'];
        $corpo = "Olá, {$usuario['nome']}!\n\n"
            . "Seu serviço \"{$servico['descricao']}\" foi finalizado.\n"
            . 'Valor: R$ ' . number_format($servico['valor'], 2, ',', '.') . "\n"
            . 'Comissão: R$ ' . number_format($servico['comissao'], 2, ',', '.') . "\n";

        mail($usuario['email'], $assunto, $corpo);
    }
}