<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));
define('APP_NAME', 'Cabinet Dr. Dupont');
define('APP_URL', 'http://localhost/DENTISTE');
define('TIMEZONE', 'Europe/Paris');

// Chemins
define('CONFIG_PATH', BASE_PATH . '/config');
define('TEMPLATE_PATH', BASE_PATH . '/templates');
define('ASSET_PATH', BASE_PATH . '/assets');
define('PUBLIC_PATH', BASE_PATH . '/public');

// Paramètres de session
define('SESSION_LIFETIME', 3600); // 1 heure

// Email de contact
define('CONTACT_EMAIL', 'contact@cabinet-dupont.fr');

// Horaires du cabinet
define('OPENING_DAYS', ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi']);
define('OPENING_TIME', '09:00');
define('CLOSING_TIME', '18:00');
define('SLOT_DURATION', 30); // minutes
