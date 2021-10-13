<?php

namespace App\Controllers;

class Home extends AbstractController {
    
    public function index() {
        $this->render('index');
    }
}