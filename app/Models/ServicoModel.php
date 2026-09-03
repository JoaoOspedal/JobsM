<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class ServicoModel
{
    public function listarTodos(): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT s.*, u.nome AS usuario_nome,
                    CASE WHEN s.data_finalizacao IS NULL THEN 'Pendente' ELSE 'Finalizado' END AS status
                FROM servicos s
                JOIN usuarios u ON u.id = s.usuario_id
                ORDER BY s.data_criacao DESC";
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalPorUsuario(int $usuarioId): float
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT COALESCE(SUM(valor), 0) AS total FROM servicos WHERE usuario_id = :id');
        $stmt->execute(['id' => $usuarioId]);
        return (float) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function pendentesPorUsuario(int $usuarioId, int $limite = 5): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare(
            'SELECT * FROM servicos
             WHERE usuario_id = :id AND data_finalizacao IS NULL
             ORDER BY data_criacao DESC
             LIMIT :limite'
        );
        $stmt->bindValue(':id', $usuarioId, PDO::PARAM_INT);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criar(string $descricao, float $valor, int $usuarioId): void {
        
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO servicos (descricao, valor, usuario_id) VALUES (:descricao, :valor, :usuario_id)');
        $stmt->execute([
            'descricao' => $descricao,
            'valor' => $valor,
            'usuario_id' => $usuarioId
        ]);
    }

    public function buscarPorId(int $id): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM servicos WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $servico = $stmt->fetch(PDO::FETCH_ASSOC);
        return $servico ?: null;
    }

    public function atualizar(int $id, string $descricao, float $valor): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('UPDATE servicos SET descricao = :descricao, valor = :valor WHERE id = :id');
        $stmt->execute([
            'descricao' => $descricao,
            'valor' => $valor,
            'id' => $id,
        ]);
    }

    public function excluir(int $id): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('DELETE FROM servicos WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}