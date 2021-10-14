<?php

namespace App;

use FastRoute;

class Router {

    private $routes;

    private $dispatcher;

    public function __construct() {
        $this->routes = require __DIR__ . '/routes.inc.php';
    }


    public function load() {
        $this->dispatcher = FastRoute\simpleDispatcher($this->routes);
        return $this;
    }

    public function dispatcher($httpMethod, $uri) {
        
        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        define('ROUTE', rawurldecode($uri));
        
        $routeInfo = $this->dispatcher->dispatch($httpMethod, ROUTE);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                (new  \App\Controllers\ErrorController)->error404();
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                (new  \App\Controllers\ErrorController)->error405();
                break;
            case FastRoute\Dispatcher::FOUND:
                $controller = explode('::',$routeInfo[1]);
                $obj = new $controller[0];
                $method = $controller[1];
                call_user_func_array([$obj, $method], $routeInfo[2]);
                // ... call $handler with $vars
                break;
        }
    }
}