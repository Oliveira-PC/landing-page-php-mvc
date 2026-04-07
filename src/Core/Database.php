<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/**
 * Classe Database
 * Responsável por gerenciar a conexão com o banco de dados MySQL via PDO.
 */
class Database
{
    private ?PDO $connection = null;

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $config = require __DIR__ . '/../../config/db.php';
            
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      
                PDO::ATTR_EMULATE_PREPARES   => false,             
            ];

            try {
                $this->connection = new PDO($dsn, $config['user'], $config['pass'], $options);
            } catch (PDOException $e) {
                error_log("Erro de Conexão PDO: " . $e->getMessage());
                throw new \Exception("Falha na conexão com o banco de dados. Tente novamente mais tarde.");
            }
        }

        return $this->connection;
    }
}