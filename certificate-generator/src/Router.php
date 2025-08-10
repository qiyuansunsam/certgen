<?php

namespace App;

class Router
{
    private $routes = [];

    /**
     * Add a GET route
     */
    public function get($path, $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    /**
     * Add a POST route
     */
    public function post($path, $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    /**
     * Handle the current request
     */
    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        $path = strtok($path, '?');
        
        // Remove trailing slash
        $path = rtrim($path, '/');
        if (empty($path)) {
            $path = '/';
        }

        // Check if route exists
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            
            if (is_callable($handler)) {
                return call_user_func($handler);
            }
            
            if (is_string($handler)) {
                return $this->callControllerMethod($handler);
            }
        }

        // Handle POST actions (for form submissions)
        if ($method === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];
            
            switch ($action) {
                case 'generate':
                    return $this->callControllerMethod('CertificateController@generate');
                case 'verify':
                    return $this->callControllerMethod('CertificateController@verify');
                default:
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid action']);
                    return;
            }
        }

        // Default route (home page)
        if ($method === 'GET' && $path === '/') {
            return $this->callControllerMethod('CertificateController@index');
        }

        // 404 Not Found
        http_response_code(404);
        echo "404 Not Found";
    }

    /**
     * Call controller method
     */
    private function callControllerMethod($handler)
    {
        if (strpos($handler, '@') === false) {
            throw new \Exception('Invalid handler format');
        }

        list($controller, $method) = explode('@', $handler);
        
        $controllerClass = "App\\Controllers\\{$controller}";
        
        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller {$controllerClass} not found");
        }

        $controllerInstance = new $controllerClass();
        
        if (!method_exists($controllerInstance, $method)) {
            throw new \Exception("Method {$method} not found in {$controllerClass}");
        }

        return call_user_func([$controllerInstance, $method]);
    }
}