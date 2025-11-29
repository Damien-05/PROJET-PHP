<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $metaDescription ?? 'Cabinet dentaire Dr. Dupont - Prenez rendez-vous en ligne' ?>">
    <title><?= $pageTitle ?? 'Cabinet Dr. Dupont' ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css?v=2.0">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <div class="nav-brand">
                    <a href="<?= APP_URL ?>/">
                        <h1>Dr. Dupont</h1>
                        <span class="subtitle">Cabinet Dentaire</span>
                    </a>
                </div>
                <ul class="nav-menu">
                    <li><a href="<?= APP_URL ?>/" class="nav-link">Accueil</a></li>
                    <li><a href="<?= APP_URL ?>/services" class="nav-link">Services</a></li>
                    <li><a href="<?= APP_URL ?>/about" class="nav-link">À propos</a></li>
                    <li><a href="<?= APP_URL ?>/news" class="nav-link">Actualités</a></li>
                    <li><a href="<?= APP_URL ?>/booking" class="btn btn-primary">Prendre RDV</a></li>
                    <?php if (App\Utils\Auth::check() && !App\Utils\Auth::isAdmin()): ?>
                        <li><a href="<?= APP_URL ?>/account" class="nav-link">👤 <?= escape(App\Utils\Auth::user()['name'] ?? 'Mon Compte') ?></a></li>
                    <?php else: ?>
                        <li><a href="<?= APP_URL ?>/login" class="nav-link">Connexion</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main>
