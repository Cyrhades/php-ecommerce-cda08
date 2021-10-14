<?php

namespace App\Controllers;


class Admin extends AbstractController {
    
    public function index() {
        $this->render('admin/index', ['flash' =>  $this->flash()->all()]);
    }
}