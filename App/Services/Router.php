<?php

namespace App\Services;

class Router
{
    private array $routes = [];
    
    private Response $response;
    
    public function __construct()
    {
        $this->response = new Response();
    }
    
    public function post(string $uri, array $action): void
    {
        $this->routes['POST'][$uri] = $action;
    }
    
    public function run(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'],'?');
        
        if (!isset($this->routes[$requestMethod][$uri])) {
        	$this->response->error('Route not found');
            return;
        }
        
        list($controllerName, $methodName) = $this->routes[$requestMethod][$uri];
        
        $controller = new $controllerName();
        $controller->$methodName();
    }
}