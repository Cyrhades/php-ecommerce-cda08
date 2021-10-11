<?php

return function(FastRoute\RouteCollector $r) {
    // page d'accueil
    $r->addRoute('GET', '/', 'App\\Controllers\\Home::index');
    
};