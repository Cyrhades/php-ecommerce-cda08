<?php

return function(FastRoute\RouteCollector $r) {
    // page d'accueil
    $r->addRoute('GET', '/', 'App\\Controllers\\Home::index');

    $r->addRoute('GET', '/inscription', 'App\\Controllers\\Register::index');
    $r->addRoute('POST', '/inscription', 'App\\Controllers\\Register::form');


    $r->addRoute('GET', '/connexion', 'App\\Controllers\\Authenticated::index');
    $r->addRoute('POST', '/connexion', 'App\\Controllers\\Authenticated::form');
    $r->addRoute('GET', '/deconnexion', 'App\\Controllers\\Authenticated::disconnect');


    $r->addRoute('GET', '/admin', 'App\\Controllers\\Admin::index');
    $r->addRoute('GET', '/admin/product', 'App\\Controllers\\AdminProduct::index');
    $r->addRoute('GET', '/admin/product/add', 'App\\Controllers\\AdminProduct::add');
    $r->addRoute('POST', '/admin/product/add', 'App\\Controllers\\AdminProduct::form');


 
    $r->addRoute('GET', '/admin/user', 'App\\Controllers\\AdminUser::index');

    $r->addRoute('GET', '/admin/user/add', 'App\\Controllers\\AdminUser::printFormAdd');
    $r->addRoute('POST', '/admin/user/add', 'App\\Controllers\\AdminUser::processFormAdd');

    $r->addRoute('GET', '/admin/user/edit/{id:\d+}', 'App\\Controllers\\AdminUser::printFormEdit');
    $r->addRoute('POST', '/admin/user/edit/{id:\d+}', 'App\\Controllers\\AdminUser::processFormEdit');

    $r->addRoute('GET', '/admin/user/delete/{id:\d+}', 'App\\Controllers\\AdminUser::delete');
};