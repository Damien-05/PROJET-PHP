<!-- Menu de navigation latéral -->
<nav class="sidebar">
    <ul class="sidebar-menu">
        <li>
            <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-dashboard"></i> Tableau de bord
            </a>
        </li>
        <li>
            <a href="rendez-vous.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'rendez-vous.php' ? 'active' : ''; ?>">
                <i class="fas fa-calendar"></i> Rendez-vous
            </a>
        </li>
        <li>
            <a href="patients.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'patients.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> Patients
            </a>
        </li>
        <li>
            <a href="services.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">
                <i class="fas fa-tooth"></i> Services
            </a>
        </li>
        <li>
            <a href="actualites.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'actualites.php' ? 'active' : ''; ?>">
                <i class="fas fa-newspaper"></i> Actualités
            </a>
        </li>
        <li>
            <a href="horaires.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'horaires.php' ? 'active' : ''; ?>">
                <i class="fas fa-clock"></i> Horaires
            </a>
        </li>
    </ul>
</nav>

<main class="main-content">
    <!-- Le contenu principal sera inséré ici -->