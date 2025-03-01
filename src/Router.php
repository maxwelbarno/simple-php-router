<?php

namespace Router;

class Router
{
    private array $routes = [];

    private function register($route, $method, $callback)
    {
        $route = trim($route, "/");
        $this->routes[$method][$route] = $callback;
    }

    public function get($route, $callback)
    {
        $this->register($route, 'GET', $callback);
    }

    public function dispatch()
    {
        // Get the requested route.
        $requestedRoute = trim($_SERVER['REQUEST_URI'], '/') ?? '/';

        $routes = $this->routes[$_SERVER['REQUEST_METHOD']];

        foreach ($routes as $route => $callback) {
            // Transform route to regex pattern.
            $routeRegex = preg_replace_callback('/{\w+(:([^}]+))?}/', function ($matches) {
                return isset($matches[1]) ? '(' . $matches[2] . ')' : '([a-zA-Z0-9_-]+)';
            }, $route);

            // Add the start and end delimiters.
            $routeRegex = '@^' . $routeRegex . '$@';

            echo $routeRegex . ", ";

            // Check if the requested route matches the current route pattern.
            if (preg_match($routeRegex, $requestedRoute, $matches)) {
                // Get all user requested route parameter values after removing the first matches.
                array_shift($matches);

                $routeParameterValues = $matches;

                // Find all route params names from route and save in $routeParameterNames
                $routeParameterNames = [];
                if (preg_match_all('/{(\w+)(:[^}]+)?}/', $route, $matches)) {
                    $routeParameterNames = $matches[1];
                }

                // Combine between route parameter names and user provided parameter values.
                $routeParameters = array_combine($routeParameterNames, $routeParameterValues);



                return  $this->resolveCallback($callback, $routeParameters);
            }
        }
        return $this->abort('404 Page not found');
    }

    private function resolveCallback($callback, $routeParameters)
    {
        if (is_callable($callback)) {
            return call_user_func_array($callback, $routeParameters);
        } elseif (is_array($callback)) {
            return call_user_func_array([new $callback[0](), $callback[1]], $routeParameters);
        }
    }

    private function abort(string $message, int $code = 404)
    {

        http_response_code($code);
        echo $message;
        exit();
    }
}
