<?php

namespace App\Controllers;

class Home {
    
    public function index() {
        include DIR_TEMPLATES.'/index.phtml';
    }
}