<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable|array $handler): void
    {
        // Converte parâmetros dinâmicos do caminho (/recurso/{id}) em Named Capture Groups da Regex
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[^/]+)', $path);
        $pattern = "#^" . $pattern . "$#";

        $this->routes[] = [
            'method'  => strtoupper($method),
            'pattern' => $pattern,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                // Isola os parâmetros nomeados capturados na URI
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $handler = $route['handler'];

                if (is_array($handler)) {
                    [$controllerInstance, $actionMethod] = $handler;
                    call_user_func_array([$controllerInstance, $actionMethod], $params);
                    return;
                }

                if (is_callable($handler)) {
                    call_user_func_array($handler, $params);
                    return;
                }
            }
        }

        Response::error('Rota não encontrada', 404);
    }
}
