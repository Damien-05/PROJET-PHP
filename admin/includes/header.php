<!-- En-tête HTML commune pour le back office -->
<?php
// Vérification de session pour toutes les pages
// TODO: include 'config/auth.php';
// TODO: checkLogin();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Back Office'; ?> - Cabinet Dr. Dupont</title>
    <link rel="stylesheet" href="assets/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <h1>Cabinet Dr. Dupont - Administration</h1>
        </div>
        <div class="header-right">
            <span>Bienvenue, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?></span>
            <a href="logout.php" class="btn-logout">Déconnexion</a>
        </div>
    </header>

    <div class="admin-container">
        <!-- Contenu des pages sera inséré ici -->