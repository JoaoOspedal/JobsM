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

    public function finalizar(int $id): void
    {
        $pdo = Database::getConnection();

        $servico = $this->buscarPorId($id);
        if (!$servico || $servico['data_finalizacao'] !== null) {
            return; 
        }

        $valor = (float) $servico['valor'];

        if ($valor > 10000) {
            $percentual = 0.20;
        } elseif ($valor > 1000) {
            $percentual = 0.10;
        } else {
            $percentual = 0.05;
        }

        $comissao = $valor * $percentual;

        $stmt = $pdo->prepare(
            'UPDATE servicos SET data_finalizacao = NOW(), comissao = :comissao WHERE id = :id'
        );
        $stmt->execute([
            'comissao' => $comissao,
            'id' => $id,
        ]);
    }

    public function listarComFiltros(array $filtros): array
    {
        $pdo = Database::getConnection();

        $sql = "SELECT s.*, u.nome AS usuario_nome,
                    CASE WHEN s.data_finalizacao IS NULL THEN 'Pendente' ELSE 'Finalizado' END AS status
                FROM servicos s
                JOIN usuarios u ON u.id = s.usuario_id
                WHERE 1=1";

        $params = [];

        if (!empty($filtros['data_inicio'])) {
            $sql .= ' AND s.data_criacao >= :data_inicio';
            $params['data_inicio'] = $filtros['data_inicio'] . ' 00:00:00';
        }

        if (!empty($filtros['data_fim'])) {
            $sql .= ' AND s.data_criacao <= :data_fim';
            $params['data_fim'] = $filtros['data_fim'] . ' 23:59:59';
        }

        if (!empty($filtros['descricao'])) {
            $sql .= ' AND s.descricao LIKE :descricao';
            $params['descricao'] = '%' . $filtros['descricao'] . '%';
        }

        if (!empty($filtros['status'])) {
            $sql .= $filtros['status'] === 'Pendente'
                ? ' AND s.data_finalizacao IS NULL'
                : ' AND s.data_finalizacao IS NOT NULL';
        }

        if (!empty($filtros['usuario_nome'])) {
            $sql .= ' AND u.nome LIKE :usuario_nome';
            $params['usuario_nome'] = '%' . $filtros['usuario_nome'] . '%';
        }

        $sql .= ' ORDER BY s.data_criacao DESC';

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}