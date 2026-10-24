<?php
class Router
{
    public function dispatch(): void
    {
        $url = trim($_GET['url'] ?? '', '/');
        $parts = $url === '' ? [] : explode('/', $url);

        $name = $parts[0] ?? 'home';
        $method = $parts[1] ?? 'index';
        $params = array_slice($parts, 2);

        if (!preg_match('/^[a-z0-9]+$/i', $name) || !preg_match('/^[a-z0-9_]+$/i', $method)) {
            $this->notFound();
            return;
        }

        $class = ucfirst(strtolower($name)) . 'Controller';

        if (!class_exists($class)) {
            $this->notFound();
            return;
        }

        $controller = new $class();

        if (!is_callable([$controller, $method])) {
            $this->notFound();
            return;
        }

        call_user_func_array([$controller, $method], $params);
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo "<h1 style='font-family: sans-serif; text-align: center; margin-top: 50px;'>404 - Page Not Found</h1>";
    }
}