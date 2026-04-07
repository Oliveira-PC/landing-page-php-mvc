<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Classe Router
 * Roteador de alta performance construído do zero, dispensando frameworks.
 */
class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    public function post(string $path, callable|array $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    public function dispatch(string $uri, string $method): void
    {
        $path = parse_url($uri, PHP_URL_PATH);
        
        if (isset($this->routes[$method][$path])) {
            $action = $this->routes[$method][$path];

            if (is_array($action)) {
                [$controllerName, $methodName] = $action;
                
                $controller = new $controllerName();
                $controller->$methodName();
                return;
            }

            call_user_func($action);
            return;
        }

        http_response_code(404);
        echo "<h1>404 - Página Não Encontrada</h1><p>A rota {$path} não existe no servidor.</p>";
    }
}