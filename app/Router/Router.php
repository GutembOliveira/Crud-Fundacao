<?php
namespace app\Router;

class Router
{
    private $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get(string $path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }
    public function delete(string $path, $callback)
    {
        $this->routes['DELETE'][$path] = $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

 public function dispatch(string $uri, string $method)
{
    $path = parse_url($uri, PHP_URL_PATH);

    if (!isset($this->routes[$method][$path])) {
        http_response_code(404);
        echo "404 - Página não encontrada";
        return;
    }

    $callback = $this->routes[$method][$path];
    if (is_callable($callback)) {
        return $callback();
    } elseif (is_string($callback) && strpos($callback, '@') !== false) {
        list($class, $method) = explode('@', $callback);
        $class = "app\\Controllers\\$class";
        if (class_exists($class)) {
            $controller = new $class();
            if (method_exists($controller, $method)) {
                return $controller->$method();
            }
        }
    }
        if (is_string($callback)) {
            $viewFile = __DIR__ . '/../Views/' . $callback . '.php';
            if (file_exists($viewFile)) {
                return require $viewFile;
            }
        }

    die("Rota configurada incorretamente");
}

}
