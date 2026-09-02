<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class UsuarioModel
{
    public function listarTodos(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT * FROM usuarios');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function criar(string $nome, string $email): void{
        $pdo = Database::getConnection();
        //prepare() + execute() pra proteger de SQL Injection
        $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email) VALUES (:nome, :email)');
        $stmt->execute([
            'nome' => $nome,
            'email' => $email,
        ]);
    }
}