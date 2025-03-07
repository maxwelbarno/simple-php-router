<?php

namespace Router;

use Exceptions\CustomException;

use function Helpers\response;

class Router
{
    private array $routes = [];
    private $url;
    private $http_request_method;
    private $response;
    private $accepted_methods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTION'];


    public function __construct($url, $http_method)
    {
        $this->url = $url;
        $this->http_request_method = $this->validateHttpMethod($http_method);
        $this->response = $GLOBALS['response'];
    }

    private function register($route, $method, $callback)
    {
        $method = $this->validateHttpMethod($method);
        $route = trim($route, "/");
        $this->routes[$method][$route] = $callback;
    }

    public function get($route, $callback)
    {
        $this->register($route, 'GET', $callback);
    }

    public function post($route, $callback)
    {
        $this->register($route, 'POST', $callback);
    }

    public function put($route, $callback)
    {
        $this->register($route, 'PUT', $callback);
    }

    public function delete($route, $callback)
    {
        $this->register($route, 'DELETE', $callback);
    }

    public function dispatch()
    {
        // Get the requested route.
        $requestedRoute = $this->url;
        $routes = $this->routes[$this->http_request_method];
        $convertToRegex = function ($matches) {
            return isset($matches[1]) ? '(' . $matches[2] . ')' : '([a-zA-Z0-9_-]+)';
        };

        foreach ($routes as $route => $callback) {
            // Transform route to regex pattern.
            $routeRegex = preg_replace_callback('/{\w+(:([^}]+))?}/', $convertToRegex, $route);

            // Add the start and end delimiters.
            $routeRegex = '@^' . $routeRegex . '$@';

            // Check if the requested route matches the current route pattern.
            if (preg_match($routeRegex, $requestedRoute, $matches)) {
                // Get all user requested route parameter values after removing the first matches.
                array_shift($matches);

                $routeParameterValues = $matches;

                // Find all route parameter names from route and save in $routeParameterNames
                $routeParameterNames = [];
                if (preg_match_all('/{(\w+)(:[^}]+)?}/', $route, $matches)) {
                    $routeParameterNames = $matches[1];
                }

                // Combine between route parameter names and user provided parameter values.
                $routeParameters = array_combine($routeParameterNames, $routeParameterValues);

                return  $this->resolveCallback($callback, $routeParameters);
            }
        }
        return $this->abort('Route Not Found');
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
        response($this->response, ["code" => $code, "error" => $message], 404);
    }

    private function validateHttpMethod($method)
    {
        try {
            if (in_array(strtoupper($method), $this->accepted_methods)) {
                return $method;
            }
            throw new CustomException("Invalid HTTP method " . $method);
        } catch (CustomException $exception) {
            $exception->render();
        }
    }
}
