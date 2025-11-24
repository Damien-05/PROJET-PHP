<?php
/**
 * Script pour corriger les chemins d'images des services
 */

require_once __DIR__ . '/../config/bootstrap.php';

use App\Utils\Database;

$db = Database::getInstance();

// Corriger les chemins d'images qui contiennent /public/
$stmt = $db->prepare("
    UPDATE services 
    SET image = REPLACE(image, '/DENTISTE/public/assets/', '/DENTISTE/assets/')
    WHERE image LIKE '%/public/%'
");
$stmt->execute();

$updated = $stmt->rowCount();

echo "✅ Chemins d'images corrigés : $updated service(s)\n";

// Afficher les services avec images
$stmt = $db->query("SELECT id, title, image FROM services WHERE image IS NOT NULL");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "\n📋 Services avec images :\n";
foreach ($services as $service) {
    echo "  - [{$service['id']}] {$service['title']}\n";
    echo "    Image: {$service['image']}\n";
}
