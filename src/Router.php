<?php

namespace Router;

class Router
{
    private array $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = explode('?', $path)[0];

        $callback = $this->routes[$method][$path] ?? null;
        if ($callback === null) {
            http_response_code(404);
            return "404 Not Found!";
        }

        if (is_array($callback)) {
            [$class, $classMethod] = $callback;
            $controller = new $class();
            return $controller->$classMethod();
        }
        return $callback;
    }
}
