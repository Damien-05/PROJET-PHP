# Gestion des images de services

## Fonctionnalité d'upload d'images

Les administrateurs peuvent maintenant ajouter des images personnalisées lors de la création d'un service.

### Caractéristiques

- **Formats acceptés** : JPG, JPEG, PNG
- **Taille maximale** : 2 MB
- **Stockage** : `/public/assets/images/services/`
- **Priorité d'affichage** : Les images uploadées ont la priorité sur les images par défaut

### Utilisation

1. Se connecter à l'espace admin : http://localhost/DENTISTE/admin/login
2. Aller dans "Services"
3. Cliquer sur "Ajouter un service"
4. Remplir les informations du service
5. Sélectionner une image via le champ "Image du service"
6. Cliquer sur "Créer le service"

### Logique d'affichage

L'application affiche les images dans l'ordre de priorité suivant :

1. **Image uploadée** : Si l'administrateur a uploadé une image personnalisée
2. **Image par titre exact** : Correspondance exacte avec le titre du service dans le tableau d'images prédéfinies
3. **Image par mot-clé** : Recherche de mots-clés dans le titre du service
4. **Image par défaut** : Image générique de consultation dentaire

### Images prédéfinies disponibles

Les services sans image uploadée utilisent automatiquement ces images par défaut :

- Consultation générale
- Détartrage
- Soin de carie
- Extraction dentaire
- Blanchiment dentaire
- Pose de couronne (image locale)
- Orthodontie (image locale)
- Implant dentaire

### Structure de la base de données

```sql
ALTER TABLE services 
ADD COLUMN image VARCHAR(255) DEFAULT NULL AFTER description;
```

### Sécurité

- Validation du type MIME
- Limite de taille de fichier
- Nom de fichier unique avec `uniqid()`
- Dossier de destination avec permissions appropriées (0755)

### Affichage

Les images sont affichées sur :

- Page d'accueil (6 premiers services)
- Page "Nos Services" (tous les services)
- Tableau d'administration (miniatures 50x50px)

### Notes techniques

- Les images sont stockées avec un préfixe `service_` suivi d'un identifiant unique
- Le chemin de l'image est stocké avec le chemin complet incluant `/DENTISTE/public/assets/images/services/`
- En cas d'échec de l'upload, le service est créé sans image (champ NULL)
