<?php

namespace App\Controllers;

use Berlioz\FlashBag\FlashBag;

class Home extends AbstractController {
    
    public function index() {
        $this->render('index', ['flash' => (new FlashBag)->all()]);
    }
}