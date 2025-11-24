<?php
/**
 * Script pour associer les images aux services existants
 */

require_once __DIR__ . '/../config/bootstrap.php';

use App\Utils\Database;

$db = Database::getInstance();

// Mapping des services vers leurs images
$serviceImages = [
    'Consultation générale' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=400&h=300&fit=crop&q=80',
    'Détartrage' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=400&h=300&fit=crop&q=80',
    'Soin de carie' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=400&h=300&fit=crop&q=80',
    'Extraction dentaire' => 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?w=400&h=300&fit=crop&q=80',
    'Blanchiment dentaire' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?w=400&h=300&fit=crop&q=80',
    'Pose de couronne' => '/DENTISTE/assets/images/couronne-dentaire.jpg',
    'Orthodontie - Consultation' => '/DENTISTE/assets/images/orthodontie.jpg',
    'Implant dentaire' => 'https://images.unsplash.com/photo-1588776814546-daab30f310ce?w=400&h=300&fit=crop&q=80'
];

echo "🖼️  Mise à jour des images des services...\n\n";

$updated = 0;
$stmt = $db->prepare("UPDATE services SET image = ? WHERE title = ?");

foreach ($serviceImages as $title => $image) {
    $stmt->execute([$image, $title]);
    if ($stmt->rowCount() > 0) {
        $updated++;
        echo "✅ $title → Image ajoutée\n";
    }
}

// Supprimer le service de test
$db->prepare("DELETE FROM services WHERE title = ?")->execute(['Test Service avec Image']);
echo "\n🗑️  Service de test supprimé\n";

echo "\n📊 Résultat : $updated services mis à jour\n\n";

// Afficher tous les services avec leurs images
echo "📋 Liste finale des services :\n";
$stmt = $db->query("SELECT id, title, image FROM services ORDER BY id");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($services as $service) {
    $imageType = '';
    if (empty($service['image'])) {
        $imageType = '❌ Sans image';
    } elseif (strpos($service['image'], 'unsplash.com') !== false) {
        $imageType = '🌐 Unsplash';
    } else {
        $imageType = '📁 Locale';
    }
    
    echo "  [{$service['id']}] {$service['title']}\n";
    echo "      $imageType : {$service['image']}\n";
}
