<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Administration</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/admin.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <h1>Cabinet Dr. Dupont</h1>
            <h2>Espace Administration</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <?= escape($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= APP_URL ?>/admin/login" class="login-form">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

                <div class="form-group">
                    <label for="email">📧 Adresse email</label>
                    <input type="email" id="email" name="email" placeholder="votre.email@exemple.com" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">🔒 Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <span style="position: relative; z-index: 1;">Se connecter →</span>
                </button>
            </form>

            <div class="login-footer">
                <a href="<?= APP_URL ?>/">← Retour au site</a>
            </div>
        </div>
    </div>
</body>
</html>
