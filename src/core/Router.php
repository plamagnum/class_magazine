<?php
/**
 * Простий роутер
 */

class Router {
    private $routes = [];

    /**
     * Додати маршрут
     */
    public function add($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    /**
     * GET маршрут
     */
    public function get($path, $controller, $action) {
        $this->add('GET', $path, $controller, $action);
    }

    /**
     * POST маршрут
     */
    public function post($path, $controller, $action) {
        $this->add('POST', $path, $controller, $action);
    }

    /**
     * Обробити запит
     */
    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            $pattern = $this->convertToRegex($route['path']);
            
            if ($route['method'] === $requestMethod && preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches); // Видаляємо повний збіг
                
                $controllerName = $route['controller'];
                $actionName = $route['action'];
                
                if (!file_exists(__DIR__ . "/../controllers/{$controllerName}.php")) {
                    $this->notFound();
                    return;
                }
                
                require_once __DIR__ . "/../controllers/{$controllerName}.php";
                
                $controller = new $controllerName();
                
                if (!method_exists($controller, $actionName)) {
                    $this->notFound();
                    return;
                }
                
                call_user_func_array([$controller, $actionName], $matches);
                return;
            }
        }

        $this->notFound();
    }

    /**
     * Конвертувати шлях у регулярний вираз
     */
    private function convertToRegex($path) {
        // Замінюємо {id} на (\d+), {slug} на ([a-z0-9-]+) тощо
        $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    /**
     * Сторінка 404
     */
    private function notFound() {
        http_response_code(404);
        echo "<h1>404 - Сторінку не знайдено</h1>";
    }
}
