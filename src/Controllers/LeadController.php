<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\WhatsAppHelper;
use App\Models\Lead;
use App\Controllers\SecurityController;

/**
 * LeadController
 * Processa o envio do formulário de orçamento e aplica sanitização.
 */
class LeadController
{
    public function store(): void
    {
        $csrfToken = filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!SecurityController::validateCsrfToken($csrfToken)) {
            http_response_code(403);
            echo "<h1 style='color:red;'>Erro 403 - Acesso Negado</h1>";
            echo "<p>Falha na validação do Token de Segurança (CSRF). Tente enviar novamente.</p>";
            return;
        }

        $nome     = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
        $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_SPECIAL_CHARS);
        $origem   = filter_input(INPUT_POST, 'origem_secao', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$nome || !$telefone || !$mensagem) {
            http_response_code(400);
            echo "<h1>Erro 400 - Dados Inválidos</h1>";
            echo "<p>Por favor, preencha todos os campos corretamente.</p>";
            return;
        }

        $leadModel = new Lead();
        $sucesso = $leadModel->create([
            'nome'         => $nome,
            'telefone'     => $telefone,
            'mensagem'     => $mensagem,
            'origem_secao' => $origem
        ]);

        if ($sucesso) {
            $linkWhatsapp = WhatsAppHelper::getLink($origem, $nome, $mensagem);

            echo "<div style='background-color: #000; color: #D4AF37; padding: 50px; text-align: center; font-family: sans-serif; min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center;'>";
            echo "<h1 style='font-size: 2.5rem; margin-bottom: 10px;'>Projeto Registrado!</h1>";
            echo "<p style='color: #ccc; font-size: 1.2rem;'>Obrigado, <b>{$nome}</b>. Estamos redirecionando você para o nosso WhatsApp para iniciarmos o atendimento...</p>";
            
            echo "<a href='{$linkWhatsapp}' style='margin-top: 30px; background-color: #2E7D32; color: #fff; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Ir para o WhatsApp Agora</a>";
            
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '{$linkWhatsapp}';
                    }, 1500);
                  </script>";
            echo "</div>";
        } else {
            http_response_code(500);
            echo "Ocorreu um erro interno ao salvar sua solicitação.";
        }
    }
}