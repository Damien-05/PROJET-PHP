<?php

declare(strict_types=1);

// Chargement de la configuration
require_once __DIR__ . '/../config/constants.php';

// Timezone
date_default_timezone_set(TIMEZONE);

// Autoloader PSR-4
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/src/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Démarrage de session sécurisée
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_samesite', 'Strict');
    session_start();
}

// Fonction helper pour échapper les données HTML
function escape(string $data): string
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Fonction helper pour rediriger
function redirect(string $path): void
{
    header('Location: ' . APP_URL . $path);
    exit;
}

// Protection CSRF
function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken(string $token): bool
{
    return !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
