<?php
//arquivo de configuração do banco de dados e PDO
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if(self::$instance === null){
            try{
                self::$instance = new PDO(
                    'mysql:host=localhost;dbname=teste;charset=utf8mb4',
                    'root',
                    '',
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            }catch(PDOException $e){
                die('Erro de conexão: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}