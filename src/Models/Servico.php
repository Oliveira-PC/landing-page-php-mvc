<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Servico
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getByCategorySlug(string $slug): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                s.id, 
                s.titulo, 
                s.descricao, 
                s.material_compativel AS materialCompativel, 
                s.imagem_url AS imagemUrl
            FROM servicos s
            INNER JOIN categorias c ON s.categoria_id = c.id
            WHERE c.slug = :slug
            ORDER BY s.created_at DESC
        ");

        $stmt->execute([':slug' => $slug]);
        
        return $stmt->fetchAll();
    }
}