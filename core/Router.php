<?php

namespace PhpYourAdimn\Core;

use PhpYourAdimn\App\Requests\LoginRequest;

class Router
{
    public $routes = [
        'GET' => [],

        'POST' => [],
    ];

    public function load($file)
    {
        $router = new $this;

        require $file;

        return $router;
    }

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            
            return  $this->callAction(...explode('@', $this->routes[$requestType][$uri]));
        }
        throw new \Exception('No routes defined');
    }

    protected function callAction($controller, $action)
    {
        $controller = "PhpYourAdimn\\App\\Controllers\\{$controller}";

        $controller =  new $controller();

        if (!method_exists($controller, $action)) {
            throw new \Exception("{$controller} does not respond to the {$action} action.");
        }
        return $controller->$action(Request::requestData());
    }
}
