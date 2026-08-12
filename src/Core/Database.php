<?php

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $host = getenv('DB_HOST') ?: 'db';
            $port = getenv('DB_PORT') ?: '3306';
            $db   = getenv('DB_DATABASE') ?: 'inventory_db';
            $user = getenv('DB_USERNAME') ?: 'inventory_user';
            $pass = getenv('DB_PASSWORD') ?: 'inventory_pass';

            $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

            $options = [
                // ATTR_EMULATE_PREPARES false garante o uso de prepared statements nativos da engine do SGBD,
                // eliminando a interpolação de strings no client-side e prevenindo SQL Injection por design.
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                throw new RuntimeException("Falha na conexão com o banco de dados: " . $e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$instance;
    }
}
