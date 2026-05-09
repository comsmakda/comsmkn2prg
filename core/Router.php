<?php
// core/Router.php

class Router
{
    private array $routes = [];

    public function add(string $method, string $pattern, callable|array $handler): void
    {
        // Convert :param → named capture group
        $regex = preg_replace('#:([a-z_]+)#', '(?P<$1>[^/]+)', $pattern);
        $this->routes[] = [
            'method'  => strtoupper($method),
            'regex'   => '#^' . $regex . '$#i',
            'handler' => $handler,
        ];
    }

    public function get(string $pattern, callable|array $handler): void  { $this->add('GET',  $pattern, $handler); }
    public function post(string $pattern, callable|array $handler): void { $this->add('POST', $pattern, $handler); }

    public function dispatch(string $uri, string $method): void
    {
        // Strip query string
        $uri = strtok($uri, '?');
        $uri = '/' . trim($uri, '/');

        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($method)) continue;
            if (preg_match($route['regex'], $uri, $matches)) {
                // Keep only named params
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $handler = $route['handler'];
                if (is_array($handler)) {
                    [$class, $action] = $handler;
                    $controller = new $class();
                    $controller->$action(...array_values($params));
                } else {
                    $handler(...array_values($params));
                }
                return;
            }
        }

        // 404
        http_response_code(404);
        require BASE_PATH . '/app/views/errors/404.php';
    }
}
