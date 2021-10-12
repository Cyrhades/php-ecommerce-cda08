<?php

namespace App\Controllers;

class Register  {
    
    public function index() {
        include DIR_TEMPLATES.'/register.phtml';
    }

    public function form() {
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            if(\sizeof($_POST)) {
                // Les controles sur les champs 
                $user = new \App\Models\User();
                $user->add($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password']);
                header('location:/');
                exit();
            }
        } 
        header('location:/');
        exit();
    }
}