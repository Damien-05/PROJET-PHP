<?php
// Script pour modifier la table users et ajouter le rôle 'patient'

require_once __DIR__ . '/../config/bootstrap.php';

use App\Utils\Database;

try {
    $db = Database::getInstance();
    
    echo "🔧 Modification de la table users...\n";
    
    // Modifier la colonne role pour ajouter 'patient'
    $sql = "ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'staff', 'patient') DEFAULT 'patient'";
    $db->exec($sql);
    
    echo "✅ Table users modifiée avec succès!\n";
    echo "   Le rôle 'patient' est maintenant disponible.\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    exit(1);
}
