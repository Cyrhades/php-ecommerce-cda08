<?php

namespace App\Models;

class User extends AbstractRepository {

    public function add($firstname, $lastname, $email, $password, $roles = ['user']) {
        $query = $this->db->prepare("INSERT INTO users (firstname, lastname, email, password, roles) VALUES (?, ?, ?, ?, ?)"); 
        $query->execute([$firstname, $lastname, $email, $password, json_encode($roles)]);
    }

    public function getAll()
    {
        $query = $this->db->prepare("SELECT * FROM users");
        $query->execute();
        return $query->fetchAll();
    }

    public function emailExists($email) {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$email]);
        return $query->fetch() ? true : false;
    }
    
    public function findByEmail($email) {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$email]);
        return $query->fetch();
    }

    public function delete($id)
    {
        $query = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $query->execute([$id]);
    }
}