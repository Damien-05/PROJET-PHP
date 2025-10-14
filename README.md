# 🦷 Cabinet Dentaire Dr. Dupont

Site web professionnel pour un cabinet dentaire avec interface d'administration complète.

## 📋 Fonctionnalités

### 🌐 Site Public
- **Page d'accueil** : Présentation du Dr. Dupont et du cabinet
- **Prise de rendez-vous** : Formulaire interactif en 4 étapes
- **Services** : Détail des soins proposés (orthodontie, implantologie, esthétique)
- **À propos** : Parcours du Dr. Dupont et présentation de l'équipe
- **Actualités** : Articles sur la santé dentaire

### 🔧 Back Office (Admin)
- **Dashboard** : Vue d'ensemble des statistiques
- **Gestion des rendez-vous** : CRUD complet avec calendrier
- **Gestion des patients** : Fiches patients et historique
- **Gestion des services** : Configuration des soins et tarifs
- **Gestion des actualités** : Publication d'articles
- **Configuration des horaires** : Paramétrage du planning

## 🛠️ Technologies Utilisées

- **Frontend** : HTML5, CSS3, JavaScript (ES5)
- **Backend** : PHP (version simple pour apprentissage)
- **Base de données** : MySQL
- **Design** : Responsive, mobile-first
- **Sécurité** : Sessions PHP, validation des données

## 📦 Structure du Projet

```
📁 Projet php/
├── 📄 index.html (Page d'accueil)
├── 📄 rendez-vous.html (Prise de RDV)
├── 📄 services.html (Services du cabinet)
├── 📄 a-propos.html (À propos)
├── 📄 actualites.html (Actualités)
├── 📄 styles.css (Styles principaux)
├── 📄 script.js (JavaScript du site)
└── 📁 admin/ (Back office)
    ├── 📄 index.php (Dashboard)
    ├── 📄 login.php (Connexion)
    ├── 📄 rendez-vous.php (Gestion RDV)
    ├── 📄 patients.php (Gestion patients)
    ├── 📄 services.php (Gestion services)
    ├── 📄 actualites.php (Gestion actualités)
    ├── 📄 horaires.php (Gestion horaires)
    ├── 📁 config/ (Configuration)
    ├── 📁 includes/ (Fichiers communs)
    └── 📁 assets/ (CSS/JS admin)
```

## 🚀 Installation

1. **Cloner le repository**
   ```bash
   git clone https://github.com/Damien-05/PROJET-PHP.git
   ```

2. **Configurer le serveur web**
   - XAMPP, WAMP ou serveur Apache/PHP
   - Placer les fichiers dans le dossier web

3. **Base de données** (à venir)
   - Configurer MySQL
   - Importer la structure SQL
   - Modifier `admin/config/database.php`

## 🎓 Contexte Pédagogique

Ce projet a été développé dans le cadre d'une formation en développement web.

**Objectifs d'apprentissage :**
- Développement frontend responsive
- Intégration HTML/CSS/JavaScript
- Initiation au PHP et MySQL
- Création d'interface d'administration
- Gestion de projet avec Git/GitHub

## 👨‍💻 Développement

**Version actuelle :** Site frontend complet + Structure back office

**Prochaines étapes :**
- [ ] Implémentation PHP du back office
- [ ] Base de données MySQL
- [ ] Système d'authentification
- [ ] Envoi d'emails automatiques
- [ ] Export de données

## 📱 Responsive Design

Le site est entièrement responsive et s'adapte à tous les écrans :
- Desktop (1200px+)
- Tablette (768px-1199px)
- Mobile (< 768px)

## 🔒 Sécurité

- Validation des données côté client et serveur
- Protection contre les injections SQL (préparé pour PDO)
- Gestion des sessions sécurisées
- Hashage des mots de passe

---

**Auteur :** Damien  
**Formation :** Développement Web  
**Année :** 2025