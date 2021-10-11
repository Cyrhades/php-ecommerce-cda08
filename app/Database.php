<?php

namespace App;

use PDO;

class Database {

    private static $pdo = null;

    public static function set() {
        if(file_exists(__DIR__.'/config.inc.php')) {
            $config = require __DIR__.'/config.inc.php';
            self::$pdo = new \PDO(
                $config['sql']['dsn'], 
                $config['sql']['username'], 
                $config['sql']['password'], 
                array(
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                )
            );
        } else {
            die('Erreur de connexion à la BDD');
        }
    }

    public static function get() {
        if(self::$pdo === null) {
            self::set();
        }
        return self::$pdo;
    }
} 