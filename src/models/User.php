<?php

namespace App\Models;

class User extends AbstractRepository {

    public function add($firstname, $lastname, $email, $password) {
        $query = $this->db->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)"); 
        $query->execute([$firstname, $lastname, $email, $password]);
    }
}