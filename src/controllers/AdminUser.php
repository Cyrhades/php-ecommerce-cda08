<?php

namespace App\Controllers;

use App\Models\User;

class AdminUser extends AbstractController {
       
    public function index() {
        $this->isAuthorized(['admin']);
        $this->render('admin/user/list', [
            'users' => (new User)->getAll()
        ]);
    }

    public function printFormAdd() {
        $this->isAuthorized(['admin']);
        $this->render('admin/user/add');
    }

    public function processFormAdd()
    {
        $this->isAuthorized(['admin']);
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
            elseif(!is_array($_POST['roles'])) {
                foreach($_POST['roles'] as $role) {
                    if(!is_string($role) || !in_array($role, $this->authRoles)) {
                        $error = 'Au moins un role ne correspond pas à une valeur attendue';
                    }                    
                }
            } 
            else {
                $user = new User();
                // Vérification (doublon)
                if($user->emailExists($_POST['email'])) {
                    $error = 'Cette adresse email est déjà utilisée.';
                } else {
                    $user->add($_POST['firstname'], $_POST['lastname'], $_POST['email'], password_hash($_POST['password'], PASSWORD_ARGON2I), $_POST['roles']);
   
                    $this->flash()->add(\Berlioz\FlashBag\FlashBag::TYPE_SUCCESS, 'Vous êtes maintenant inscrit');
                    $this->redirectTo('/admin/user');
                }
            }
        } else {
            $error = 'Le formulaire n\'a pas été soumis correctement.';
        }
        $this->render('admin/user/add', ['error' => $error]);
    }

    public function printFormEdit($id) {
        $this->isAuthorized(['admin']);
        $userModel = new User();
        $user = $userModel->findById((int) $id);

        if($user !== false) {
            $this->render('admin/user/edit', ['user' => $user]);
        } else {
            $this->redirectTo('/admin/user');
        }
    }

    public function processFormEdit($id) {
        $this->isAuthorized(['admin']);
        $userModel = new User();
        $user = $userModel->findById((int) $id);

        if($user !== false && \sizeof($_POST)) {
            // Vérification (minimaliste des données)
            if(empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email'])) {
                $error = 'Veuillez remplir tous les champs.';
            } 
            elseif(!is_string($_POST['firstname']) || strlen($_POST['firstname']) > 60 ||
                    !is_string($_POST['lastname']) || strlen($_POST['lastname']) > 60) {
                $error = 'La longueur maximum autorisé pour vos nom / prénom est de 60 caractères';
            } 
            elseif(!is_string($_POST['email']) || !filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)) {
                $error = 'Votre adresse email n\'est pas correcte';
            } 
            elseif(!is_array($_POST['roles'])) {
                foreach($_POST['roles'] as $role) {
                    if(!is_string($role) || !in_array($role, $this->authRoles)) {
                        $error = 'Au moins un role ne correspond pas à une valeur attendue';
                    }                    
                }
            } 
            else {
                // Vérification (doublon)
                if($_POST['email'] !== $user->email && $user->emailExists($_POST['email'])) {
                    $error = 'Cette adresse email est déjà utilisée.';
                } else {
                    $userModel->edit(
                        $user->id,
                        $_POST['firstname'], 
                        $_POST['lastname'], 
                        $_POST['email'], 
                        !empty($_POST['password']) 
                            ? password_hash($_POST['password'], PASSWORD_ARGON2I)
                            : $user->password, 
                        $_POST['roles']
                    );
   
                    $this->flash()->add(\Berlioz\FlashBag\FlashBag::TYPE_SUCCESS, "l'utilisateur a été modifié");
                    $this->redirectTo('/admin/user');
                }
            }
        } else {
            $error = 'Le formulaire n\'a pas été soumis correctement.';
        }
        $this->render('admin/user/edit', ['error' => $error]);
    }

    public function delete($id) {
        $this->isAuthorized(['admin']);
        $user = new User();
        $user->delete($id);
        $this->redirectTo('/admin/user');
    }
}