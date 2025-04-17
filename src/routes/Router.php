<?php
namespace App\Routes;

class Router {
    private array $routes = [];
    
    // Registrar ruta GET
    public function get(string $path, $callback): void {
        $this->routes['GET'][$path] = $callback;
    }
    
    // Registrar ruta POST
    public function post(string $path, $callback): void {
        $this->routes['POST'][$path] = $callback;
    }
    
    // Ejecutar el router
    public function run(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Eliminar la barra final si existe
        $uri = rtrim($uri, '/');
        
        // Si la ruta está vacía, establecer como /
        if (empty($uri)) {
            $uri = '/';
        }
        
        // Comprobar si existe una ruta exacta
        if (isset($this->routes[$method][$uri])) {
            $callback = $this->routes[$method][$uri];
            $this->executeCallback($callback);
            return;
        }
        
        // Buscar rutas con parámetros
        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = $this->convertRouteToRegex($route);
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Quitar la primera coincidencia (completa)
                $this->executeCallback($callback, $matches);
                return;
            }
        }
        
        // Ruta no encontrada
        header("HTTP/1.0 404 Not Found");
        require_once __DIR__ . '/../views/errors/404.php';
    }
    
    // Convertir ruta a expresión regular
    private function convertRouteToRegex(string $route): string {
        $route = preg_replace('/\/{([^\/]+)}/', '/([^/]+)', $route);
        return '@^' . $route . '$@D';
    }
    
    // Ejecutar el callback correspondiente
    private function executeCallback($callback, array $params = []): void {
        if (is_callable($callback)) {
            call_user_func_array($callback, $params);
            return;
        }
        
        if (is_string($callback)) {
            $this->callControllerAction($callback, $params);
            return;
        }
        
        if (is_array($callback) && count($callback) === 2) {
            [$controller, $action] = $callback;
            $this->callController($controller, $action, $params);
            return;
        }
    }
    
    // Llamar al controlador y acción
    private function callController(string $controller, string $action, array $params = []): void {
        $controllerInstance = new $controller();
        call_user_func_array([$controllerInstance, $action], $params);
    }
    
    // Llamar al controlador por string (Controller@action)
    private function callControllerAction(string $callback, array $params = []): void {
        [$controller, $action] = explode('@', $callback);
        
        // Añadir namespace para el controlador
        $controller = "App\\Controllers\\{$controller}";
        
        $controllerInstance = new $controller();
        call_user_func_array([$controllerInstance, $action], $params);
    }
} 