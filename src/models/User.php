<?php

namespace App\Models;

class User extends AbstractRepository {

    public function add($firstname, $lastname, $email, $password) {
        $query = $this->db->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)"); 
        $query->execute([$firstname, $lastname, $email, $password]);
    }

    public function emailExists($email) {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$email]);
        return $query->fetch() ? true : false;
    }
}