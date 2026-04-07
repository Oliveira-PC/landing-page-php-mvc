<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Servico;

/**
 * PortfolioController
 * API REST para listagem dinâmica do catálogo.
 */
class PortfolioController
{
    public function get(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $slug = filter_input(INPUT_GET, 'category_slug', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$slug) {
            http_response_code(400); 
            echo json_encode(['error' => 'O parâmetro category_slug é obrigatório.']);
            return;
        }

        $servicoModel = new Servico();
        $servicos = $servicoModel->getByCategorySlug($slug);

        if (empty($servicos)) {
            http_response_code(404);
            echo json_encode(['message' => 'Nenhum serviço encontrado para esta categoria.']);
            return;
        }

        http_response_code(200);
        echo json_encode(['data' => $servicos]);
    }
}