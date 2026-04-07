<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\SecurityController;

/**
 * HomeController
 * Responsável por orquestrar a exibição da Landing Page principal.
 */
class HomeController
{
    public function index(): void
    {
        $csrfToken = SecurityController::generateCsrfToken();

        require_once __DIR__ . '/../Views/layout/header.php';
        require_once __DIR__ . '/../Views/home/index.php';
        require_once __DIR__ . '/../Views/layout/footer.php';
    }
}