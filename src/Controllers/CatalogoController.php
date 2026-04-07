<?php
declare(strict_types=1);

namespace App\Controllers;

/**
 * CatalogoController
 * Responsável por forçar o download do PDF do catálogo e evitar cache de navegador.
 */
class CatalogoController
{
    public function download(): void
    {
        $arquivo = __DIR__ . '/../../public/assets/docs/catalogo.pdf';

        if (!file_exists($arquivo)) {
            http_response_code(404);
            echo "<h1>404 - Catálogo Indisponível</h1>";
            echo "<p>O catálogo em PDF está sendo atualizado e retornará em breve.</p>";
            return;
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Catalogo_JC_Personalizados.pdf"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($arquivo));

        readfile($arquivo);
        exit;
    }
}