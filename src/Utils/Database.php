<?php

declare(strict_types=1);

namespace App\Utils;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require CONFIG_PATH . '/database.php';
            
            try {
                $dsn = sprintf(
                    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                    $config['host'],
                    $config['port'] ?? 3306,
                    $config['dbname'],
                    $config['charset']
                );
                
                self::$instance = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $config['options'] ?? []
                );
            } catch (PDOException $e) {
                die('Erreur de connexion à la base de données: ' . $e->getMessage());
            }
        }
        
        return self::$instance;
    }

    private function __construct() {}
    private function __clone() {}
}
