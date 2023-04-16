<?php

namespace App\RMVC\Route;

class Route
{
    /**
     * @var array
     */
    private static array $routesGet = [];

    /**
     * @var array
     */
    private static array $routesPost = [];

    /**
     * @param string $route
     * @param array $controller
     * 
     * @return RouteConfiguration
     */
    public static function get(string $route, array $controller): RouteConfiguration
    {
        $routeConfiguration = new RouteConfiguration($route, $controller[0], $controller[1]);
        static::$routesGet[] =  $routeConfiguration;
        return $routeConfiguration;
    }

    /**
     * @param string $route
     * @param array $controller
     * 
     * @return RouteConfiguration
     */
    public static function post(string $route, array $controller): RouteConfiguration
    {
        $routeConfiguration = new RouteConfiguration($route, $controller[0], $controller[1]);
        static::$routesPost[] =  $routeConfiguration;
        return $routeConfiguration;
    }

    /**
     * @return array
     */
    public static function getRoutesGet(): array
    {
        return self::$routesGet;
    }

    /**
     * @return array
     */
    public static function getRoutesPost(): array
    {
        return self::$routesPost;
    }

    /**
     * @param string $url
     * 
     * @return void
     */
    public static function redirect(string $url): void
    {
        header('Location: ' . $url);
    }

     /**
     * 
     * @return void
     */
    public static function notfound(): void
    {
        header('Location: /notfound');
    }

}