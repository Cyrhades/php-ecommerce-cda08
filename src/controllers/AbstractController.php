<?php

namespace App\Controllers;

use \Berlioz\FlashBag\FlashBag;

abstract class AbstractController  {
    protected $authRoles = ['admin', 'webmaster', 'marketing', 'user'];
    
    public function isAuthorized($roles) {
        if (is_array($roles) && isset($_SESSION['user']) && isset($_SESSION['user']->roles)) {
            $userRoles = json_decode($_SESSION['user']->roles);
            foreach ($roles as $role) {
                if(is_string($role) && in_array($role, $userRoles)) {
                    return true;
                }
            }
        }
        (new ErrorController)->error401();
    }

    public function render($template, $data = []): void
    {
        $flash = $this->flash()->all();
        extract($data);
        include DIR_TEMPLATES.'/'.$template.'.phtml';
        exit();
    }

    public function redirectTo($url): void
    {
        header('location:'.$url);
        exit();
    }

    public function redirectIfConnected() 
    {
        if (isset($_SESSION['user'])) {
            $this->redirectTo('/');
        }
    }

    public function flash() 
    {
        return new \Berlioz\FlashBag\FlashBag();
    }
}