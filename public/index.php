<?php

define('DIR_TEMPLATES', dirname(__DIR__).'/templates');

require dirname(__DIR__).'/vendor/autoload.php';


$router = new App\Router();
$router->load()->dispatcher($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);