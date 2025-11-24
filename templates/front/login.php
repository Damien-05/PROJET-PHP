<?php
$pageTitle = 'Connexion - Cabinet Dr. Dupont';
include __DIR__ . '/../layout/header.php';
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <h2>Connexion Patient</h2>
                <p class="auth-subtitle">Accédez à votre espace personnel</p>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?= escape($_SESSION['error']) ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= escape($_SESSION['success']) ?>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?= APP_URL ?>/login" class="auth-form">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                    
                    <div class="form-group">
                        <label for="email">📧 Email</label>
                        <input type="email" id="email" name="email" required 
                               placeholder="votre.email@example.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">🔒 Mot de passe</label>
                        <input type="password" id="password" name="password" required 
                               placeholder="••••••••">
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">
                        Se connecter
                    </button>
                </form>
                
                <div class="auth-footer">
                    <p>Pas encore de compte ? <a href="<?= APP_URL ?>/register">Créer un compte</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>
