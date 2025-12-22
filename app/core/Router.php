<?php
/**
 * Custom PHP Router
 * 
 * Supports GET, POST, PUT, DELETE methods with dynamic route parameters.
 * No framework dependencies.
 */

declare(strict_types=1);

class Router
{
    private array $routes = [];
    private array $params = [];

    /**
     * Register a GET route
     */
    public function get(string $path, string $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    /**
     * Register a POST route
     */
    public function post(string $path, string $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    /**
     * Register a PUT route
     */
    public function put(string $path, string $handler): void
    {
        $this->addRoute('PUT', $path, $handler);
    }

    /**
     * Register a DELETE route
     */
    public function delete(string $path, string $handler): void
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    /**
     * Add route to the routes array
     */
    private function addRoute(string $method, string $path, string $handler): void
    {
        // Convert route pattern to regex
        // {param} becomes (?P<param>[a-zA-Z0-9_-]+) for safe URL slugs
        // This restricts parameters to alphanumeric, underscore, and hyphen
        $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $path);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[$method][$pattern] = $handler;
    }

    /**
     * Get the current request method
     */
    private function getMethod(): string
    {
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Support method override via _method field or X-HTTP-Method-Override header
        if ($method === 'POST') {
            if (isset($_POST['_method'])) {
                $method = strtoupper($_POST['_method']);
            } elseif (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
                $method = strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
            }
        }
        
        return $method;
    }

    /**
     * Get the current request path
     */
    private function getPath(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return $path ?: '/';
    }

    /**
     * Match a route and extract parameters
     */
    private function match(string $method, string $path): ?array
    {
        if (!isset($this->routes[$method])) {
            return null;
        }

        foreach ($this->routes[$method] as $pattern => $handler) {
            if (preg_match($pattern, $path, $matches)) {
                // Extract named parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                return [
                    'handler' => $handler,
                    'params' => $params,
                ];
            }
        }

        return null;
    }

    /**
     * Dispatch the request to the appropriate controller
     */
    public function dispatch(): void
    {
        $method = $this->getMethod();
        $path = $this->getPath();

        $match = $this->match($method, $path);

        if ($match === null) {
            $this->handleNotFound();
            return;
        }

        $this->params = $match['params'];
        [$controllerName, $action] = explode('@', $match['handler']);

        // Load and instantiate controller
        $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';
        
        if (!file_exists($controllerFile)) {
            $this->handleNotFound();
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            $this->handleNotFound();
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            $this->handleNotFound();
            return;
        }

        // Call the controller action with route parameters
        call_user_func_array([$controller, $action], $this->params);
    }

    /**
     * Get route parameters
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Handle 404 Not Found
     */
    private function handleNotFound(): void
    {
        http_response_code(404);
        View::render('pages/404', [
            'title' => 'Page Not Found',
        ]);
    }
}
