<?php
require_once __DIR__ . '/../config/bootstrap.php';

use App\Utils\Database;

try {
    $db = Database::getInstance();
    
    // Images correspondantes aux actualités
    $newsImages = [
        1 => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=800&h=500&fit=crop&q=80', // Cabinet dentaire moderne
        2 => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=800&h=500&fit=crop&q=80', // Détartrage/hygiène dentaire
    ];
    
    echo "Mise à jour des images des actualités:\n";
    echo "======================================\n\n";
    
    foreach ($newsImages as $id => $imageUrl) {
        $stmt = $db->prepare('UPDATE news SET image = :image WHERE id = :id');
        $stmt->execute([
            'image' => $imageUrl,
            'id' => $id
        ]);
        
        if ($stmt->rowCount() > 0) {
            echo "✓ Article $id: Image mise à jour\n";
        } else {
            echo "✗ Article $id: Non trouvé\n";
        }
    }
    
    echo "\n✓ Mise à jour terminée!\n";
    
} catch (PDOException $e) {
    echo "✗ Erreur: " . $e->getMessage() . "\n";
}
