<?php

namespace App\Controllers;

use App\Models\User;

class Authenticated  {
    
    public function index() {        
        include DIR_TEMPLATES.'/authenticated.phtml';
    }

    public function form() {
       
        if(\sizeof($_POST)) {
            if(empty($_POST['email']) || !is_string($_POST['email']) || !filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)) {
                $error = 'Votre adresse email n\'est pas correcte';
            } 
            elseif(empty($_POST['password']) || !is_string($_POST['password'])) {
                $error = 'Votre mot de passe ne peut pas être vide';
            }
            else {
                $userModel = new User();
                $user = $userModel->findByEmail($_POST['email']);
                if(!$user) {
                    $error = 'Votre adresse email n\'est pas reconnue';
                }
                elseif(!password_verify($_POST['password'], $user->password)) {
                    $error = 'Votre mot de passe est incorrect';
                }
                else {
                    $user->password = null;
                    $_SESSION['user'] = $user;
                    header('Location: /');
                    exit();
                }
            }
            
        } else {
            $error = 'Un probleme est survenu';
        }
        
        include DIR_TEMPLATES.'/authenticated.phtml';
    }
}