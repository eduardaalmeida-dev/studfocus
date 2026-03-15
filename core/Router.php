<?php

class Router
{
    private $routes = [];

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function dispatch($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if(isset($this->routes[$method][$uri]))
        {
            $action = $this->routes[$method][$uri];

            $controller = $action[0];
            $method = $action[1];

            $controller = new $controller();

            return $controller->$method();
        }

        echo "404 - Página não encontrada";
    }
}