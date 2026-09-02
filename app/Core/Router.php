<?php
//roteador simples
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, string $controller, string $method): void
    {
        $this->routes['GET'][$path] = [$controller, $method];
    }

    public function post(string $path, string $controller, string $method): void
    {
        $this->routes['POST'][$path] = [$controller, $method];
    }

    public function dispatch(string $uri, string $httpMethod): void
    {
        $path = '/' . trim($uri, '/');

        if (!isset($this->routes[$httpMethod][$path])) {
            http_response_code(404);
            echo 'Página não encontrada';
            return;
        }

        [$controllerClass, $methodName] = $this->routes[$httpMethod][$path];
        $fullClass = "App\\Controllers\\$controllerClass";

        $controller = new $fullClass();
        $controller->$methodName();
    }
}