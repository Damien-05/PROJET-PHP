<?php
require_once __DIR__ . '/../config/bootstrap.php';

use App\Utils\Database;

try {
    $db = Database::getInstance();
    
    // Vérifier si la colonne existe déjà
    $stmt = $db->query("SHOW COLUMNS FROM news LIKE 'image'");
    
    if ($stmt->rowCount() === 0) {
        $db->exec('ALTER TABLE news ADD COLUMN image VARCHAR(255) DEFAULT NULL AFTER excerpt');
        echo "✓ Colonne 'image' ajoutée à la table news\n";
    } else {
        echo "ℹ La colonne 'image' existe déjà dans la table news\n";
    }
    
} catch (PDOException $e) {
    echo "✗ Erreur: " . $e->getMessage() . "\n";
}
