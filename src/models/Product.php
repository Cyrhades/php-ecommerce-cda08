<?php

namespace App\Models;

class Product extends AbstractRepository {

    public function add($title, $description, $price) {
        $query = $this->db->prepare("INSERT INTO products (title, description, price, photos) VALUES (?, ?, ?, ?)"); 
        $query->execute([$title, $description, $price, json_encode([])]);
    }

    public function getAll() {
        $query = $this->db->prepare("SELECT * FROM products");
        $query->execute();
        return $query->fetchAll();
    }
}