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
        $base = dirname($_SERVER['SCRIPT_NAME']);
        $path = '/' . trim(str_replace($base, '', $uri), '/');

        if (isset($this->routes[$method][$path])) {
            [$controller, $action] = $this->routes[$method][$path];
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
