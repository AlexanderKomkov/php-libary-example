<?php

namespace App\RMVC\Route;

use App\Http\Controllers\PostController;
use JetBrains\PhpStorm\NoReturn;

class RouteDispatcher
{

    /**
     * @var string
     */
    private string $requestUri = '/';

    /**
     * @var array
     */
    private array $paramMap = [];

    private array $paramRequestMap = [];

    /**
     * @var RouteConfiguration
     */
    private RouteConfiguration $routeConfiguration;

    /**
     * @param RouteConfiguration $routeConfiguration
     */
    public function __construct(RouteConfiguration $routeConfiguration)
    {
        $this->routeConfiguration = $routeConfiguration;
    }

    /**
     * @return void
     */
    public function process(): void
    {
        $this->saveRequestUri();
        $this->setParamMap();
        $this->makeRegexRequest();
        $this->run();
    }

    /**
     * @return void
     */
    private function saveRequestUri(): void
    {
        if ($_SERVER['REQUEST_URI'] !== '/')
        {
            $this->requestUri = $this->clean($_SERVER['REQUEST_URI']);
            $this->routeConfiguration->route = $this->clean($this->routeConfiguration->route);
        }
    }

    /**
     * @param mixed $uri
     * 
     * @return string
     */
    private function clean($uri): string
    {
        return preg_replace('/(^\/)|(\/$)/', '', $uri);
    }

    /**
     * @return void
     */
    private function setParamMap(): void
    {
        $routeArray = explode('/', $this->routeConfiguration->route);

        foreach ($routeArray as $paramKey => $param)
        {
            if (preg_match('/{.*}/', $param))
            {
                $this->paramMap[$paramKey] = preg_replace('/(^{)|(}$)/', '', $param);
            }
        }

    }

    /**
     * @return void
     */
    private function makeRegexRequest(): void
    {
        $requestUriArray = explode('/', $this->requestUri);

        foreach ($this->paramMap as $paramKey => $param) {
            if (!isset($requestUriArray[$paramKey])) continue;

            $this->paramRequestMap[$param] = $requestUriArray[$paramKey];
            $requestUriArray[$paramKey] = '{.*}';
        }

        $this->requestUri = implode('/', $requestUriArray);

        $this->prepareRegex();
    }

    /**
     * @return void
     */
    private function prepareRegex(): void
    {
        $this->requestUri = str_replace('/', '\/', $this->requestUri);
    }

    /**
     * @return void
     */
    private function run(): void
    {
        if (preg_match("/^$this->requestUri$/", $this->routeConfiguration->route))
        {
            $this->render();
        }
    }

    /**
     * @return void
     */
    private function render(): void
    {
        $ClassName = $this->routeConfiguration->controller;
        $action = $this->routeConfiguration->action;

        print((new $ClassName)->$action(...$this->paramRequestMap));
        die();
    }
}