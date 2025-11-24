# Guide d'installation

## Prérequis

- PHP 8.0 ou supérieur
- MySQL 8.0 ou supérieur
- Serveur web (Apache/Nginx) ou XAMPP/WAMP
- Extension PHP PDO activée

## Installation

### 1. Cloner ou télécharger le projet

```bash
git clone [URL_DU_REPO]
cd DENTISTE
```

### 2. Configuration de la base de données

#### a. Créer la base de données

```bash
mysql -u root -p
```

#### b. Importer le schéma

```bash
mysql -u root -p < sql/schema.sql
```

Ou via phpMyAdmin :
- Créer une base de données nommée `dentiste`
- Importer le fichier `sql/schema.sql`

#### c. Configurer les identifiants

Éditer `config/database.php` :

```php
return [
    'host' => '127.0.0.1',
    'dbname' => 'dentiste',
    'username' => 'root',        // Votre utilisateur MySQL
    'password' => '',            // Votre mot de passe MySQL
    'charset' => 'utf8mb4',
    // ...
];
```

### 3. Configuration du serveur web

#### Option A: Avec XAMPP

1. Copier le dossier `DENTISTE` dans `C:/xampp/htdocs/`
2. Démarrer Apache et MySQL depuis le panneau XAMPP
3. Accéder à `http://localhost/DENTISTE/`

#### Option B: Avec le serveur PHP intégré

```bash
cd public
php -S localhost:8000
```

Puis accéder à `http://localhost:8000/`

#### Option C: Configuration Apache (production)

Créer un VirtualHost :

```apache
<VirtualHost *:80>
    ServerName cabinet-dupont.local
    DocumentRoot "C:/xampp/htdocs/DENTISTE/public"
    
    <Directory "C:/xampp/htdocs/DENTISTE/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Créer un fichier `.htaccess` dans `public/` :

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

### 4. Ajuster les constantes (si nécessaire)

Éditer `config/constants.php` pour adapter l'URL de base :

```php
define('APP_URL', 'http://localhost/DENTISTE');
// ou pour le serveur PHP intégré :
// define('APP_URL', 'http://localhost:8000');
```

### 5. Vérifier les permissions

Sous Linux/Mac, assurez-vous que le serveur web peut lire les fichiers :

```bash
chmod -R 755 /path/to/DENTISTE
```

## Accès à l'application

### Front Office (Public)
- URL: `http://localhost/DENTISTE/`
- Pages disponibles:
  - Accueil: `/`
  - Services: `/services`
  - À propos: `/about`
  - Actualités: `/news`
  - Prendre RDV: `/booking`

### Back Office (Administration)
- URL: `http://localhost/DENTISTE/admin/login`
- Identifiants par défaut:
  - **Email**: `admin@cabinet-dupont.fr`
  - **Mot de passe**: `Admin123!`

⚠️ **Important**: Changez immédiatement le mot de passe par défaut en production !

## Dépannage

### Erreur de connexion à la base de données
- Vérifier que MySQL est démarré
- Vérifier les identifiants dans `config/database.php`
- Vérifier que la base `dentiste` existe

### Page blanche / Erreur 500
- Activer l'affichage des erreurs PHP (développement uniquement):
  ```php
  // Ajouter en haut de config/bootstrap.php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  ```
- Vérifier les logs d'erreur PHP
- Vérifier les permissions des fichiers

### Routes ne fonctionnent pas
- Vérifier que `mod_rewrite` est activé (Apache)
- Vérifier que le fichier `.htaccess` est présent dans `public/`
- Vérifier la configuration de `APP_URL` dans `config/constants.php`

### Problème avec les créneaux horaires
- Vérifier que la timezone est correcte dans `config/constants.php`
- Vérifier que les horaires sont configurés dans la table `schedules`

## Sécurité (Production)

Avant de déployer en production :

1. **Désactiver l'affichage des erreurs**
   ```php
   ini_set('display_errors', 0);
   ```

2. **Changer les identifiants par défaut**
   - Changer le mot de passe admin
   - Utiliser un utilisateur MySQL dédié (pas `root`)

3. **Configurer HTTPS**
   - Obtenir un certificat SSL
   - Forcer HTTPS dans la configuration Apache/Nginx

4. **Sauvegardes régulières**
   - Base de données
   - Fichiers de l'application

5. **Mettre à jour PHP et MySQL régulièrement**

## Support

Pour toute question ou problème, consulter la documentation complète dans le dossier `docs/`.
