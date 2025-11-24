<?php
/**
 * Script pour supprimer le service de test
 */

require_once __DIR__ . '/../config/bootstrap.php';

use App\Utils\Database;

$db = Database::getInstance();

// Supprimer le service de test
$stmt = $db->prepare("DELETE FROM services WHERE id = ?");
$stmt->execute([9]);

echo "✅ Service de test supprimé!\n";

// Afficher les services restants
echo "\n📋 Services actuels :\n";
$stmt = $db->query("SELECT id, title, image FROM services ORDER BY id");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($services as $service) {
    $imageStatus = $service['image'] ? '🖼️ Avec image' : '❌ Sans image';
    echo "  [{$service['id']}] {$service['title']} - $imageStatus\n";
}
