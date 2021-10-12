<?php

namespace App\Controllers;

class Register  {
    
    public function index() {
        include DIR_TEMPLATES.'/register.phtml';
    }

    public function form() {
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
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
                    $user = new \App\Models\User();
                    // Vérification (doublon)
                    if($user->emailExists($_POST['email'])) {
                        $error = 'Cette adresse email est déjà utilisée.';
                    } else {
                        $user->add($_POST['firstname'], $_POST['lastname'], $_POST['email'], password_hash($_POST['password'], PASSWORD_ARGON2I));
                        // @todo Ajouter flashbag
                        header('location:/');
                        exit();
                    }
                }
            } else {
                $error = 'Le formulaire n\'pas été soumis correctement.';
            }
        }
        include DIR_TEMPLATES.'/register.phtml';
    }
}