<?php
// Système d'alertes et messages
// Affichage des messages de succès, erreur, information

// TODO: Fonction pour afficher les messages
// TODO: Gestion des types de messages (success, error, warning, info)
// TODO: Messages flash en session

?>

<!-- Système d'alertes à développer -->
<div class="alerts-container">
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-error">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
</div>