<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Model Lead
 * Responsável por persistir as conversões (contatos) no banco de dados.
 */
class Lead
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO leads (nome, telefone, mensagem, origem_secao) 
            VALUES (:nome, :telefone, :mensagem, :origem)
        ");

        return $stmt->execute([
            ':nome'     => $data['nome'],
            ':telefone' => $data['telefone'], 
            ':mensagem' => $data['mensagem'],
            ':origem'   => $data['origem_secao']
        ]);
    }
}