<?php

return function(FastRoute\RouteCollector $r) {
    // page d'accueil
    $r->addRoute('GET', '/', 'App\\Controllers\\Home::index');

    $r->addRoute('GET', '/inscription', 'App\\Controllers\\Register::index');
    $r->addRoute('POST', '/inscription', 'App\\Controllers\\Register::form');
};