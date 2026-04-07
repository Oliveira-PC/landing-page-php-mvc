<?php
declare(strict_types=1);

namespace App\Controllers;

/**
 * SecurityController
 * Responsável pela auditoria e proteção contra ataques Web (CSRF).
 */
class SecurityController
{
    public static function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }


    public static function validateCsrfToken(?string $submittedToken): bool
    {
        if (empty($_SESSION['csrf_token']) || $submittedToken === null) {
            return false;
        }

        return hash_equals($_SESSION['csrf_token'], $submittedToken);
    }
}