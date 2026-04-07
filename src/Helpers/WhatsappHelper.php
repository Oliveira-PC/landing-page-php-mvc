<?php
declare(strict_types=1);

namespace App\Helpers;

/**
 * WhatsAppHelper
 * Responsável por gerar os links dinâmicos de redirecionamento para o WhatsApp.
 */
class WhatsAppHelper
{

    public static function getLink(string $sectionId, string $nomeCliente = '', string $mensagemCliente = ''): string
    {
        $config = require __DIR__ . '/../../config/whatsapp.php';
        $numero = $config['numero_destino'];

        $mensagens = [
            'secao_laser'      => "Olá! Tenho interesse nos serviços de Gravação/Corte a Laser.",
            'secao_3d'         => "Olá! Tenho interesse nos serviços de impressão 3D.",
            'secao_sublimacao' => "Olá! Tenho interesse nos produtos de Sublimação (Canecas, Camisas, etc).",
            'home_hero_form'   => "Olá! Meu nome é *{$nomeCliente}*. Solicitei um orçamento no site e meu projeto é:\n\n_{$mensagemCliente}_"
        ];

        $textoFinal = $mensagens[$sectionId] ?? "Olá! Gostaria de solicitar um orçamento para um projeto exclusivo.";
        
        return "https://api.whatsapp.com/send?phone={$numero}&text=" . urlencode($textoFinal);
    }
}