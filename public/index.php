<?php
declare(strict_types=1);

session_start();

spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Router;
use App\Controllers\SecurityController;

$router = new Router();

// ==========================================
// REGISTRO DE ROTAS
// ==========================================

// Rota inicial usando Array Syntax para Instanciar o Controller
$router->get('/', [App\Controllers\HomeController::class, 'index']);

// Recebimento do Formulário de Leads
$router->post('/api/leads', [App\Controllers\LeadController::class, 'store']);

// Rota do Catálogo de Portfólio
$router->get('/api/portfolio', [App\Controllers\PortfolioController::class, 'get']);

// Download do Catálogo PDF
$router->get('/catalogo/download', [App\Controllers\CatalogoController::class, 'download']);

// Despacha a requisição
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);