# Diagramme de Cas d'Utilisation

## Acteurs

### Patient (Utilisateur public)
- Consulter la page d'accueil
- Consulter les services
- Consulter la page "À propos"
- Consulter les actualités
- Consulter une actualité détaillée
- S'inscrire / Se connecter
- Prendre rendez-vous
- Consulter son compte
- Voir ses rendez-vous

### Administrateur/Équipe (Dr. Dupont)
- Se connecter / Se déconnecter
- Gérer les rendez-vous
  - Consulter les rendez-vous
  - Modifier le statut d'un rendez-vous (confirmer, annuler, terminer)
- Gérer les patients
  - Consulter la liste des patients
  - Consulter les détails d'un patient
- Gérer les services
  - Créer un service
  - Modifier un service
  - Activer/Désactiver un service
- Gérer les actualités
  - Créer une actualité
  - Modifier une actualité
  - Publier/Dépublier une actualité
- Gérer les horaires
  - Modifier les horaires d'ouverture

## Cas d'utilisation principaux

### Front Office

1. **Prendre rendez-vous**
   - Acteur: Patient
   - Description: Le patient remplit un formulaire avec ses informations personnelles, choisit un service, une date et un créneau horaire disponible
   - Préconditions: Aucune
   - Postconditions: Un rendez-vous est créé avec le statut "pending", le patient (s'il est nouveau) est ajouté à la base

2. **Consulter les services**
   - Acteur: Patient
   - Description: Le patient consulte la liste des services offerts avec leurs descriptions, durées et prix
   - Préconditions: Aucune
   - Postconditions: Aucune

3. **Consulter les actualités**
   - Acteur: Patient
   - Description: Le patient consulte les actualités publiées par le cabinet
   - Préconditions: Des actualités doivent être publiées
   - Postconditions: Aucune

### Back Office

4. **Gérer les rendez-vous**
   - Acteur: Administrateur
   - Description: L'administrateur consulte la liste des rendez-vous et peut modifier leur statut
   - Préconditions: Être authentifié
   - Postconditions: Le statut du rendez-vous est mis à jour

5. **Gérer les services**
   - Acteur: Administrateur
   - Description: L'administrateur peut créer, modifier ou activer/désactiver des services
   - Préconditions: Être authentifié
   - Postconditions: Les services sont mis à jour dans la base de données

6. **Gérer les actualités**
   - Acteur: Administrateur
   - Description: L'administrateur peut créer, modifier et publier des actualités
   - Préconditions: Être authentifié
   - Postconditions: Les actualités sont disponibles sur le site public si publiées

---

## Diagramme textuel

```
┌─────────────────┐
│     Patient     │
└────────┬────────┘
         │
         ├─── Consulter page d'accueil
         ├─── Consulter services
         ├─── Consulter "À propos"
         ├─── Consulter actualités
         ├─── Lire une actualité
         │
         ├─── S'inscrire
         ├─── Se connecter
         ├─── Consulter son compte
         ├─── Voir ses rendez-vous
         │
         └─── Prendre rendez-vous
                 │
                 ├─── Sélectionner service
                 ├─── Choisir date
                 ├─── Choisir créneau horaire
                 └─── Saisir informations personnelles

┌─────────────────┐
│ Administrateur  │
└────────┬────────┘
         │
         ├─── Se connecter
         ├─── Se déconnecter
         │
         ├─── Gérer rendez-vous
         │       ├─── Consulter rendez-vous
         │       └─── Modifier statut
         │
         ├─── Gérer patients
         │       └─── Consulter liste patients
         │
         ├─── Gérer services
         │       ├─── Créer service
         │       ├─── Modifier service
         │       └─── Activer/Désactiver
         │
         ├─── Gérer actualités
         │       ├─── Créer actualité
         │       ├─── Modifier actualité
         │       └─── Publier/Dépublier
         │
         └─── Gérer horaires
                 └─── Modifier horaires ouverture
```
