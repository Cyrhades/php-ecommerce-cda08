<?php

namespace App\Controllers;


class ErrorController extends AbstractController {
    
    public function error401() 
    {
        header('HTTP/1.0 401 Unauthorized');
        $this->render('errors/error401');
        exit();
    }

    public function error404() 
    {
        header('HTTP/1.0 404 Not Found');
        $this->render('errors/error404');
        exit();
    }

    public function error405() 
    {
        header('HTTP/1.0 405 Method Not Allowed');
        $this->render('errors/error405');
        exit();
    }

}
