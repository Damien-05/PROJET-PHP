<?php
$pageTitle = 'Créer un compte - Cabinet Dr. Dupont';
include __DIR__ . '/../layout/header.php';
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <h2>Créer un compte</h2>
                <p class="auth-subtitle">Rejoignez-nous pour gérer vos rendez-vous facilement</p>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?= escape($_SESSION['error']) ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?= APP_URL ?>/register" class="auth-form">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">👤 Prénom</label>
                            <input type="text" id="first_name" name="first_name" required 
                                   placeholder="Jean" value="<?= escape($_POST['first_name'] ?? '') ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">👤 Nom</label>
                            <input type="text" id="last_name" name="last_name" required 
                                   placeholder="Dupont" value="<?= escape($_POST['last_name'] ?? '') ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">📧 Email</label>
                        <input type="email" id="email" name="email" required 
                               placeholder="jean.dupont@example.com" value="<?= escape($_POST['email'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">📞 Téléphone</label>
                        <input type="tel" id="phone" name="phone" required 
                               placeholder="06 12 34 56 78" value="<?= escape($_POST['phone'] ?? '') ?>">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="date_of_birth">🎂 Date de naissance</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" required 
                                   min="1900-01-01" max="<?= date('Y-m-d') ?>"
                                   value="<?= escape($_POST['date_of_birth'] ?? '') ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="gender">⚤ Genre</label>
                            <select id="gender" name="gender" required>
                                <option value="">Sélectionner</option>
                                <option value="M" <?= ($_POST['gender'] ?? '') === 'M' ? 'selected' : '' ?>>Homme</option>
                                <option value="F" <?= ($_POST['gender'] ?? '') === 'F' ? 'selected' : '' ?>>Femme</option>
                                <option value="other" <?= ($_POST['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Autre</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">🏠 Adresse</label>
                        <textarea id="address" name="address" rows="2" required 
                                  placeholder="12 rue de la Paix, 75001 Paris"><?= escape($_POST['address'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">🔒 Mot de passe</label>
                        <input type="password" id="password" name="password" required 
                               placeholder="••••••••" minlength="8">
                        <small>Au moins 8 caractères</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirm">🔒 Confirmer le mot de passe</label>
                        <input type="password" id="password_confirm" name="password_confirm" required 
                               placeholder="••••••••">
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">
                        Créer mon compte
                    </button>
                </form>
                
                <div class="auth-footer">
                    <p>Déjà un compte ? <a href="<?= APP_URL ?>/login">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>
