<?php

namespace App\RMVC\Route;

class RouteConfiguration
{
    /**
     * @var string
     */
    public string $route;

    /**
     * @var string
     */
    public string $controller;

    /**
     * @var string
     */
    public string $action;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $middleware;

    /**
     * @param string $route
     * @param string $controller
     * @param string $action
     */
    public function __construct(string $route, string $controller, string $action)
    {
        $this->route = $route;
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * @param string $name
     * 
     * @return RouteConfiguration
     */
    public function name(string $name): RouteConfiguration
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $middleware
     * 
     * @return RouteConfiguration
     */
    public function middleware(string $middleware): RouteConfiguration
    {
        $this->middleware = $middleware;
        return $this;
    }

}