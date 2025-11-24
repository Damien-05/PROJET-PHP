<?php
// Script de réinitialisation du mot de passe admin

require_once __DIR__ . '/../config/bootstrap.php';

use App\Utils\Database;

$db = Database::getInstance();

// Nouveau mot de passe
$newPassword = 'Admin123!';
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Mise à jour
$stmt = $db->prepare("UPDATE users SET password = ? WHERE email = 'admin@cabinet-dupont.fr'");
$stmt->execute([$hashedPassword]);

echo "✅ Mot de passe réinitialisé avec succès!\n";
echo "Email: admin@cabinet-dupont.fr\n";
echo "Mot de passe: Admin123!\n";
echo "Hash: " . $hashedPassword . "\n";
