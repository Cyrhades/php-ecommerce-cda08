<?php

namespace App\Models;

class Product extends AbstractRepository {

    public function add($title, $description, $price) {
        $query = $this->db->prepare("INSERT INTO products (title, description, price, photos) VALUES (?, ?, ?, ?)"); 
        $query->execute([$title, $description, $price, json_encode([])]);
    }
}