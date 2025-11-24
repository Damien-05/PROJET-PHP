<?php
/**
 * Script de test pour créer un service avec une image
 */

require_once __DIR__ . '/../config/bootstrap.php';

use App\Utils\Database;

$db = Database::getInstance();

// Créer un service de test
$stmt = $db->prepare("
    INSERT INTO services (title, description, image, duration, price, is_active, display_order)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$title = 'Test Service avec Image';
$description = 'Service de test pour vérifier l\'affichage des images';
$image = '/DENTISTE/assets/images/couronne-dentaire.jpg'; // Utiliser une image existante pour le test
$duration = 30;
$price = 50.00;
$isActive = 1;
$displayOrder = 999;

$stmt->execute([$title, $description, $image, $duration, $price, $isActive, $displayOrder]);

echo "✅ Service de test créé avec succès!\n";
echo "ID: " . $db->lastInsertId() . "\n";
echo "Titre: $title\n";
echo "Image: $image\n\n";

// Afficher tous les services
echo "📋 Liste des services :\n";
$stmt = $db->query("SELECT id, title, image FROM services ORDER BY id");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($services as $service) {
    $imageStatus = $service['image'] ? '🖼️ ' . $service['image'] : '❌ Pas d\'image';
    echo "  [{$service['id']}] {$service['title']} - $imageStatus\n";
}
