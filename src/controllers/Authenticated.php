<?php

namespace App\Controllers;

use App\Models\User;

class Authenticated extends AbstractController {
    
    public function index() {  
        $this->redirectIfConnected();
        $this->render('authenticated');
    }

    public function form() {
        $this->redirectIfConnected();
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
                    session_regenerate_id(true);
                    $user->password = null;
                    $_SESSION['user'] = $user;
                    $this->flash()->add(\Berlioz\FlashBag\FlashBag::TYPE_SUCCESS, 'Vous êtes maintenant connecté');
                    $this->redirectTo('/');
                }
            }
            
        } else {
            $error = 'Un probleme est survenu';
        }
        
        $this->render('authenticated', ['error' => $error]);
    }

    public function disconnect() {  
        unset($_SESSION['user']);
        session_regenerate_id(true);
        
        $this->flash()->add(\Berlioz\FlashBag\FlashBag::TYPE_ERROR, 'Vous êtes maintenant déconnecté');
        $this->redirectTo('/');
    }
}