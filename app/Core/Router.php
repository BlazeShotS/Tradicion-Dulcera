<?php

class Router
{
    private array $routes = [];

    public function get(string $path, array $callback): void
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, array $callback): void
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Prefer explicit BASE_URL from config.php when available (more reliable in some hosts)
        $base = defined('BASE_URL') ? BASE_URL : dirname($_SERVER['SCRIPT_NAME']);
        // Normalize base and uri
        $base = rtrim($base, '/');
        $uri = '/' . ltrim($uri, '/');
        $path = '/' . trim((string) preg_replace('#^' . preg_quote($base, '#') . '#', '', $uri), '/');

        // try exact match
        if (isset($this->routes[$method][$path])) {
            [$controller, $action] = $this->routes[$method][$path];
            $instance = new $controller();
            $instance->$action();
            return;
        }

        // try with/without trailing slash
        $altPath = rtrim($path, '/') ?: '/';
        if (isset($this->routes[$method][$altPath])) {
            [$controller, $action] = $this->routes[$method][$altPath];
            $instance = new $controller();
            $instance->$action();
            return;
        }

        $this->notFound();
    }

    private function notFound(): void
    {
        header('HTTP/1.0 404 Not Found');
        echo '<h1>404 — Página no encontrada</h1>';
    }
}
