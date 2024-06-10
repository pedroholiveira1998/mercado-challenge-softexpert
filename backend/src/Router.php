<?php

namespace App;

class Router
{
    protected $routes = [];

    public function get($uriPattern, $callback)
    {
        $this->addRoute('GET', $uriPattern, $callback);
    }

    public function post($uriPattern, $callback)
    {
        $this->addRoute('POST', $uriPattern, $callback);
    }

    public function put($uriPattern, $callback)
    {
        $this->addRoute('PUT', $uriPattern, $callback);
    }

    public function patch($uriPattern, $callback)
    {
        $this->addRoute('PATCH', $uriPattern, $callback);
    }

    public function delete($uriPattern, $callback)
    {
        $this->addRoute('DELETE', $uriPattern, $callback);
    }

    protected function addRoute($method, $uriPattern, $callback)
    {
        $uriPattern = preg_replace('/\{([^\}]+)\}/', '(?P<$1>[^/]+)', $uriPattern);
        $uriPattern = '/^' . str_replace('/', '\/', $uriPattern) . '$/';
        $this->routes[$method][$uriPattern] = $callback;
    }

    public function dispatch($method, $uri)
    {
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $uriPattern => $callback) {
                if ($this->matchRoute($uriPattern, $uri, $params)) {
                    $params = array_values($params);
                    return call_user_func_array($callback, $params);
                }
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Route not found.']);
    }

    protected function matchRoute($pattern, $uri, &$params)
    {
        if (preg_match($pattern, $uri, $matches)) {
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            return true;
        }

        return false;
    }
}
