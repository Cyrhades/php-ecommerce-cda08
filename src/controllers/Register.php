<?php

namespace App\Controllers;

use App\Models\User;

class Register extends AbstractController {
    
    public function index() {
        $this->redirectIfConnected();
        $this->render('register');
    }

    public function form() {
        $this->redirectIfConnected();
        if(\sizeof($_POST)) {
            // Vérification (minimaliste des données)
            if(empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['password'])) {
                $error = 'Veuillez remplir tous les champs.';
            } 
            elseif(!is_string($_POST['firstname']) || strlen($_POST['firstname']) > 60 ||
                    !is_string($_POST['lastname']) || strlen($_POST['lastname']) > 60) {
                $error = 'La longueur maximum autorisé pour vos nom / prénom est de 60 caractères';
            } 
            elseif(!is_string($_POST['email']) || !filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)) {
                $error = 'Votre adresse email n\'est pas correcte';
            } 
            else {
                $user = new User();
                // Vérification (doublon)
                if($user->emailExists($_POST['email'])) {
                    $error = 'Cette adresse email est déjà utilisée.';
                } else {
                    $user->add($_POST['firstname'], $_POST['lastname'], $_POST['email'], password_hash($_POST['password'], PASSWORD_ARGON2I));
   
                    $this->flash()->add(\Berlioz\FlashBag\FlashBag::TYPE_SUCCESS, 'Vous êtes maintenant inscrit');
                    $this->redirectTo('/');
                }
            }
        } else {
            $error = 'Le formulaire n\'a pas été soumis correctement.';
        }
        $this->render('register', ['error' => $error]);
    }
}