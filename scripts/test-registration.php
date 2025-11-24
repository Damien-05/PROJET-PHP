<?php
// Script de test pour créer un compte patient de démonstration

require_once __DIR__ . '/../config/bootstrap.php';

use App\Controllers\PatientAuthController;

echo "🧪 Test de création de compte patient...\n\n";

// Simuler les données POST
$_POST = [
    'csrf_token' => generateCsrfToken(),
    'first_name' => 'Jean',
    'last_name' => 'Dupuis',
    'email' => 'jean.dupuis@example.com',
    'phone' => '06 12 34 56 78',
    'date_of_birth' => '1990-05-15',
    'gender' => 'M',
    'address' => '123 Rue de la Santé, 75014 Paris',
    'password' => 'Patient123!',
    'password_confirm' => 'Patient123!'
];

try {
    $controller = new PatientAuthController();
    
    // Vérifier si l'email existe déjà
    $db = \App\Utils\Database::getInstance();
    $stmt = $db->prepare("SELECT email FROM patients WHERE email = ?");
    $stmt->execute(['jean.dupuis@example.com']);
    
    if ($stmt->fetch()) {
        echo "ℹ️  Le compte existe déjà, suppression...\n";
        $db->exec("DELETE FROM users WHERE email = 'jean.dupuis@example.com'");
        $db->exec("DELETE FROM patients WHERE email = 'jean.dupuis@example.com'");
        echo "✅ Ancien compte supprimé\n\n";
    }
    
    echo "📝 Création du compte...\n";
    echo "   Nom: Jean Dupuis\n";
    echo "   Email: jean.dupuis@example.com\n";
    echo "   Téléphone: 06 12 34 56 78\n";
    echo "   Date de naissance: 15/05/1990\n";
    echo "   Genre: Homme\n";
    echo "   Mot de passe: Patient123!\n\n";
    
    // Appeler la méthode register (elle va rediriger, on capture ça)
    ob_start();
    $controller->register();
    ob_end_clean();
    
    // Vérifier si le patient a été créé
    $stmt = $db->prepare("SELECT * FROM patients WHERE email = ?");
    $stmt->execute(['jean.dupuis@example.com']);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($patient) {
        echo "✅ Patient créé avec succès!\n";
        echo "   ID Patient: " . $patient['id'] . "\n";
        echo "   Nom complet: " . $patient['first_name'] . " " . $patient['last_name'] . "\n\n";
        
        // Vérifier l'utilisateur
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute(['jean.dupuis@example.com']);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo "✅ Utilisateur créé avec succès!\n";
            echo "   ID User: " . $user['id'] . "\n";
            echo "   Rôle: " . $user['role'] . "\n";
            echo "   Hash password: " . substr($user['password'], 0, 30) . "...\n\n";
            
            // Tester la connexion
            echo "🔐 Test de connexion...\n";
            $userModel = new \App\Models\User($db);
            $authenticatedUser = $userModel->verifyCredentials('jean.dupuis@example.com', 'Patient123!');
            
            if ($authenticatedUser) {
                echo "✅ Authentification réussie!\n";
                echo "   Le compte fonctionne parfaitement!\n\n";
                
                echo "📋 Résumé:\n";
                echo "   ✅ Table patients: OK\n";
                echo "   ✅ Table users: OK\n";
                echo "   ✅ Hash password: OK\n";
                echo "   ✅ Authentification: OK\n\n";
                
                echo "🎉 Test complet réussi!\n";
                echo "   Vous pouvez vous connecter avec:\n";
                echo "   Email: jean.dupuis@example.com\n";
                echo "   Mot de passe: Patient123!\n";
            } else {
                echo "❌ Erreur: Authentification échouée\n";
            }
        } else {
            echo "❌ Erreur: Utilisateur non créé dans la table users\n";
        }
    } else {
        echo "❌ Erreur: Patient non créé dans la table patients\n";
        if (isset($_SESSION['error'])) {
            echo "   Message d'erreur: " . $_SESSION['error'] . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "   Trace: " . $e->getTraceAsString() . "\n";
}
