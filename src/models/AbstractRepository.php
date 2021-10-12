<?php

namespace App\Models;

use App\Database;

abstract class AbstractRepository {
    protected $db;
    
    public function __construct() {
        $this->db = Database::get();
    }
}