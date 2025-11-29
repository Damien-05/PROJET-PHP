<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin - Cabinet Dr. Dupont' ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/admin.css">
</head>
<body class="admin-body">
    <?php if (isset($hideNav) && $hideNav): ?>
        <!-- No navigation -->
    <?php else: ?>
    <nav class="admin-nav">
        <div class="admin-brand">
            <h1>Cabinet Dr. Dupont</h1>
            <span>Administration</span>
        </div>
        <ul class="admin-menu">
            <li><a href="<?= APP_URL ?>/admin/dashboard">📊 Dashboard</a></li>
            <li><a href="<?= APP_URL ?>/admin/appointments">📅 Rendez-vous</a></li>
            <li><a href="<?= APP_URL ?>/admin/patients">👥 Patients</a></li>
            <li><a href="<?= APP_URL ?>/admin/services">🦷 Services</a></li>
            <li><a href="<?= APP_URL ?>/admin/news">📰 Actualités</a></li>
        </ul>
        <div class="admin-user">
            <span>👤 <?= escape(\App\Utils\Auth::user()['name'] ?? 'Admin') ?></span>
            <a href="<?= APP_URL ?>/admin/logout" class="logout-btn">Déconnexion</a>
        </div>
    </nav>
    <?php endif; ?>

    <main class="admin-main">
