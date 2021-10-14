<?php

namespace App\Controllers;

use App\Models\Product;

class AdminProduct extends AbstractController {
    
    public function index() {
        $this->render('admin/product/list');
    }

    public function add() {
        $this->render('admin/product/add');
    }

    public function form()
    {
        if(\sizeof($_POST)) {
            if(empty($_POST['title']) || empty($_POST['description']) || empty($_POST['price'])) {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            } 
            elseif(!is_string($_POST['title']) || strlen($_POST['title']) > 160 ||
                    !is_string($_POST['description'])) {
                $error = 'Vérifier vos données';
            } 
            elseif($_POST['price'] <= 0) {
                $error = 'Le prix doit être supérieur à 0€';
            } 
            else {
                $product = new Product();               
                $product->add($_POST['title'], $_POST['description'], $_POST['price']);
                $this->flash()->add(\Berlioz\FlashBag\FlashBag::TYPE_SUCCESS, 'Le produit a bien été créé');
                $this->redirectTo('/admin/product');  
            }
        } else {
            $error = 'Le formulaire n\'a pas été soumis correctement.';
        }
        $this->render('admin/product/add', ['error' => $error]);
    }
}