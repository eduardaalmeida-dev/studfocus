<?php

class Router
{
    private array $routes = [];

    public function get(string $path, string $controller, string $method): void
    {
        $this->routes[] = ['GET', $path, $controller, $method];
    }

    public function post(string $path, string $controller, string $method): void
    {
        $this->routes[] = ['POST', $path, $controller, $method];
    }

    public function dispatch(string $uri, string $httpMethod): void
    {
        $uri = strtok($uri, '?');
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes as [$method, $path, $controller, $action]) {
            $pattern = preg_replace('/\{[a-z]+\}/', '([^/]+)', $path);
            $pattern = "#^{$pattern}$#";

            if ($httpMethod === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                require_once __DIR__ . "/../app/controllers/{$controller}.php";
                $ctrl = new $controller();
                call_user_func_array([$ctrl, $action], $matches);
                return;
            }
        }

        http_response_code(404);
        require __DIR__ . '/../app/views/layouts/404.php';
    }
}
