<?php

declare(strict_types=1);

namespace App\Utils;

class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->basePath = $basePath;
    }

    public function get(string $path, callable $callback): void
    {
        $this->addRoute('GET', $path, $callback);
    }

    public function post(string $path, callable $callback): void
    {
        $this->addRoute('POST', $path, $callback);
    }

    private function addRoute(string $method, string $path, callable $callback): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
        ];
    }

    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
        
        // Retirer la query string
        if (($pos = strpos($requestUri, '?')) !== false) {
            $requestUri = substr($requestUri, 0, $pos);
        }
        
        // Retirer le base path
        if (!empty($this->basePath)) {
            $requestUri = substr($requestUri, strlen($this->basePath));
        }
        
        $requestUri = $requestUri ?: '/';
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }
            
            $pattern = $this->convertToRegex($route['path']);
            
            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches);
                call_user_func_array($route['callback'], $matches);
                return;
            }
        }
        
        $this->notFound();
    }

    private function convertToRegex(string $path): string
    {
        $path = preg_replace('/\{(\w+)\}/', '([^/]+)', $path);
        return '#^' . $path . '$#';
    }

    private function notFound(): void
    {
        http_response_code(404);
        require TEMPLATE_PATH . '/errors/404.php';
        exit;
    }
}
