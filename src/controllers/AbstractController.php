<?php

namespace App\Controllers;

use \Berlioz\FlashBag\FlashBag;

abstract class AbstractController  {

    public function render($template, $data = []): void
    {
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
}