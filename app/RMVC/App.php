<?php

namespace App\RMVC;

use App\RMVC\Route\Route;
use App\RMVC\Route\RouteDispatcher;

class App
{
    /**
     * @return void
     */
    public static function run(): void
    {
        if (preg_match('/^\/api\//', $_SERVER['REQUEST_URI'])) 
        {
            require_once('../routes/api.php');
        }
        else 
        {
            require_once('../routes/web.php'); 
        }

        $requestMethod = ucfirst(strtolower($_SERVER['REQUEST_METHOD']));

        $methodName = 'getRoutes' . $requestMethod;

        if (in_array($requestMethod, ['Post', 'Get']))
        {
            foreach (Route::$methodName() as $routeConfiguration)
            {
                $routeDispatcher = new RouteDispatcher($routeConfiguration);
                $routeDispatcher->process();
            }

            Route::notfound();
        }
    }
}