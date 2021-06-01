<?php

namespace PhpYourAdmin\Core;

use DI\Container;
use Exception;

class Router
{
    const HOME_ROUTE = 'database/dashboard';

    public $container;

    /**
     * @param DI\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Array of GET and POST routes
     *@var array $routes 
     */
    public $routes = [
        'GET' => [],

        'POST' => [],
    ];

    /**
     * Loads routes from the routes file path
     * 
     * @param string $file 
     * @return Router
     */
    public function load(string $file)
    {
        $router = new $this($this->container);
        if (!file_exists($file)) {
            throw new Exception('The routes filepath dosent exist');
        }
        require $file;

        return $router;
    }

    /**
     * Set a get route in the routes property array
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get(string $uri, string $controller): void
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Set a post route in the routes property array
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post(string $uri, string $controller): void
    {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * Redirects the user to the appropriate Controller and method
     * 
     * @param string $uri
     * @param string $requestType GET or POST
     */
    public function direct(string $uri, string $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return  $this->callAction(...explode('@', $this->routes[$requestType][$uri]));
        }
        throw new \Exception('No routes defined');
    }

    /**
     * Create a controller instance and call the appropriate method-action
     * 
     * @param string $controller
     * @param string $action
     */
    protected function callAction(string $controller, string $action)
    {
        $controller = "PhpYourAdmin\\App\\Controllers\\{$controller}";

        if (!method_exists($controller, $action)) {
            throw new \Exception("{$controller} does not respond to the {$action} action.");
        }

        $controller = $this->container->get($controller);

        return $controller->$action();
    }
}
