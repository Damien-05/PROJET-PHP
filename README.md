# Application de Gestion des Rendez-vous - Cabinet Dr. Dupont

## Description
Application web PHP/MySQL pour la gestion des rendez-vous du cabinet dentaire du Dr. Dupont.

## Structure du projet
```
DENTISTE/
├── config/           # Configuration (database, app)
├── src/             # Code PHP orienté objet
│   ├── Models/      # Classes métier
│   ├── Controllers/ # Contrôleurs
│   └── Utils/       # Utilitaires
├── public/          # Point d'entrée (index.php)
├── templates/       # Vues HTML/PHP
│   ├── front/       # Pages publiques
│   └── admin/       # Back office
├── assets/          # CSS, JS, images
├── sql/             # Schéma de base de données
└── docs/            # Documentation et diagrammes UML
```

## Installation

1. **Importer la base de données**
```bash
mysql -u root -p < sql/schema.sql
```

2. **Configurer l'application**
Éditer `config/database.php` avec vos identifiants MySQL.

3. **Accéder à l'application**
- Front office: http://localhost/DENTISTE/
- Back office: http://localhost/DENTISTE/admin
- Identifiants par défaut: admin@cabinet-dupont.fr / Admin123!

## Fonctionnalités

### Front Office
- Page d'accueil avec présentation du cabinet
- Prise de rendez-vous en ligne
- Présentation des services
- Page à propos
- Actualités

### Back Office
- Gestion des rendez-vous
- Gestion des services
- Gestion des actualités
- Gestion des patients
- Gestion des horaires

## Technologies
- PHP 8.0+ (POO)
- MySQL 8.0+
- HTML5 / CSS3
- Responsive design

## Sécurité
- Mots de passe hashés (PASSWORD_DEFAULT)
- Protection CSRF
- Requêtes préparées (PDO)
- Validation des données
- Sessions sécurisées

## Auteur
Projet développé dans le cadre d'une formation backend web et mobile.
