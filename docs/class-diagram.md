# Diagramme de Classes

## Vue d'ensemble

Le système utilise une architecture MVC (Model-View-Controller) avec programmation orientée objet.

---

## Classes Principales

### 1. Model (Classe abstraite)
**Responsabilité**: Classe de base pour tous les modèles, fournit les opérations CRUD génériques

**Attributs**:
- `- db: PDO` - Instance de connexion à la base de données
- `# table: string` - Nom de la table associée

**Méthodes**:
- `+ __construct(db: PDO): void`
- `+ findAll(): array` - Récupère tous les enregistrements
- `+ findById(id: int): ?array` - Récupère un enregistrement par ID
- `+ delete(id: int): bool` - Supprime un enregistrement
- `# insert(data: array): int` - Insère un nouvel enregistrement
- `# update(id: int, data: array): bool` - Met à jour un enregistrement

---

### 2. Patient extends Model
**Responsabilité**: Gestion des patients

**Attributs**:
- `# table: string = 'patients'`

**Méthodes**:
- `+ create(data: array): int` - Crée un nouveau patient
- `+ updatePatient(id: int, data: array): bool` - Met à jour un patient
- `+ findByEmail(email: string): ?array` - Recherche un patient par email
- `+ search(query: string): array` - Recherche de patients

---

### 3. Appointment extends Model
**Responsabilité**: Gestion des rendez-vous

**Attributs**:
- `# table: string = 'appointments'`

**Méthodes**:
- `+ create(data: array): int` - Crée un rendez-vous
- `+ updateAppointment(id: int, data: array): bool` - Met à jour un rendez-vous
- `+ updateStatus(id: int, status: string): bool` - Met à jour le statut
- `+ findByPatient(patientId: int): array` - Rendez-vous d'un patient
- `+ findByDate(date: string): array` - Rendez-vous d'une date
- `+ findUpcoming(limit: int): array` - Prochains rendez-vous
- `+ isTimeSlotAvailable(date: string, time: string, excludeId: ?int): bool` - Vérifie disponibilité
- `+ getAvailableSlots(date: string, serviceId: int): array` - Créneaux disponibles

---

### 4. Service extends Model
**Responsabilité**: Gestion des services proposés

**Attributs**:
- `# table: string = 'services'`

**Méthodes**:
- `+ create(data: array): int` - Crée un service
- `+ updateService(id: int, data: array): bool` - Met à jour un service
- `+ findActive(): array` - Récupère les services actifs
- `+ toggleActive(id: int): bool` - Active/Désactive un service

---

### 5. News extends Model
**Responsabilité**: Gestion des actualités

**Attributs**:
- `# table: string = 'news'`

**Méthodes**:
- `+ create(data: array): int` - Crée une actualité
- `+ updateNews(id: int, data: array): bool` - Met à jour une actualité
- `+ findPublished(limit: int): array` - Récupère les actualités publiées
- `+ publish(id: int): bool` - Publie une actualité
- `+ unpublish(id: int): bool` - Dépublie une actualité

---

### 6. User extends Model
**Responsabilité**: Gestion des utilisateurs administrateurs

**Attributs**:
- `# table: string = 'users'`

**Méthodes**:
- `+ create(data: array): int` - Crée un utilisateur
- `+ updateUser(id: int, data: array): bool` - Met à jour un utilisateur
- `+ findByEmail(email: string): ?array` - Recherche par email
- `+ verifyPassword(password: string, hash: string): bool` - Vérifie le mot de passe

---

### 7. Schedule extends Model
**Responsabilité**: Gestion des horaires d'ouverture

**Attributs**:
- `# table: string = 'schedules'`

**Méthodes**:
- `+ updateSchedule(id: int, data: array): bool` - Met à jour un horaire
- `+ findByDay(day: string): ?array` - Horaire d'un jour
- `+ getOpenDays(): array` - Jours ouverts

---

### 8. Database (Singleton)
**Responsabilité**: Gestion de la connexion à la base de données

**Attributs**:
- `- static instance: ?PDO` - Instance unique de PDO

**Méthodes**:
- `+ static getInstance(): PDO` - Retourne l'instance PDO
- `- __construct(): void` - Constructeur privé
- `- __clone(): void` - Clone privé

---

### 9. Router
**Responsabilité**: Routage des requêtes HTTP

**Attributs**:
- `- routes: array` - Liste des routes enregistrées
- `- basePath: string` - Chemin de base

**Méthodes**:
- `+ __construct(basePath: string): void`
- `+ get(path: string, callback: callable): void` - Enregistre une route GET
- `+ post(path: string, callback: callable): void` - Enregistre une route POST
- `+ dispatch(): void` - Distribue la requête
- `- convertToRegex(path: string): string` - Convertit en regex
- `- notFound(): void` - Gère les erreurs 404

---

### 10. Auth (Static)
**Responsabilité**: Gestion de l'authentification et des sessions

**Méthodes**:
- `+ static check(): bool` - Vérifie si l'utilisateur est connecté
- `+ static user(): ?array` - Retourne les données de l'utilisateur
- `+ static login(user: array): void` - Connecte un utilisateur
- `+ static logout(): void` - Déconnecte l'utilisateur
- `+ static requireAuth(): void` - Requiert l'authentification
- `+ static isAdmin(): bool` - Vérifie si l'utilisateur est admin

---

### 11. HomeController
**Responsabilité**: Contrôleur pour les pages publiques

**Attributs**:
- `- serviceModel: Service`
- `- newsModel: News`

**Méthodes**:
- `+ __construct(): void`
- `+ index(): void` - Page d'accueil
- `+ services(): void` - Page des services
- `+ about(): void` - Page "À propos"
- `+ news(): void` - Liste des actualités
- `+ newsDetail(id: int): void` - Détail d'une actualité

---

### 12. AppointmentController
**Responsabilité**: Gestion des rendez-vous côté public

**Attributs**:
- `- appointmentModel: Appointment`
- `- patientModel: Patient`
- `- serviceModel: Service`

**Méthodes**:
- `+ __construct(): void`
- `+ book(): void` - Formulaire de prise de rendez-vous
- `+ getAvailableSlots(): void` - API pour créneaux disponibles
- `- validateBookingForm(data: array): array` - Validation du formulaire

---

### 13. AuthController
**Responsabilité**: Gestion de l'authentification

**Attributs**:
- `- userModel: User`

**Méthodes**:
- `+ __construct(): void`
- `+ showLoginForm(): void` - Affiche le formulaire de connexion
- `+ login(): void` - Traite la connexion
- `+ logout(): void` - Déconnexion

---

### 14. Admin\DashboardController
**Responsabilité**: Contrôleur pour l'administration

**Attributs**:
- `- appointmentModel: Appointment`
- `- patientModel: Patient`
- `- serviceModel: Service`
- `- newsModel: News`

**Méthodes**:
- `+ __construct(): void`
- `+ index(): void` - Dashboard principal
- `+ appointments(): void` - Gestion des rendez-vous
- `+ updateAppointmentStatus(): void` - Modifie le statut d'un rendez-vous
- `+ patients(): void` - Liste des patients
- `+ services(): void` - Gestion des services
- `+ createService(): void` - Crée un service
- `+ news(): void` - Gestion des actualités
- `+ createNews(): void` - Crée une actualité

---

## Relations entre les classes

### Héritage
- `Patient` hérite de `Model`
- `Appointment` hérite de `Model`
- `Service` hérite de `Model`
- `News` hérite de `Model`
- `User` hérite de `Model`
- `Schedule` hérite de `Model`

### Association
- `Appointment` → `Patient` (many-to-one)
- `Appointment` → `Service` (many-to-one)
- `News` → `User` (many-to-one)
- Tous les contrôleurs utilisent `Database` via leurs modèles

### Dépendances
- Tous les contrôleurs dépendent de leurs modèles respectifs
- `AuthController` utilise `Auth`
- `Router` utilise les contrôleurs

---

## Diagramme textuel simplifié

```
┌─────────────┐
│    Model    │ (abstract)
└──────┬──────┘
       │
       ├──────┬──────┬──────┬──────┬──────┬
       │      │      │      │      │      │
   Patient Service News  User  Appointment Schedule

┌──────────────┐     ┌──────────────┐
│   Database   │────→│     PDO      │
└──────────────┘     └──────────────┘
   (Singleton)

┌────────────────────────────┐
│     HomeController         │
├────────────────────────────┤
│ - serviceModel: Service    │
│ - newsModel: News          │
└────────────────────────────┘

┌────────────────────────────┐
│  AppointmentController     │
├────────────────────────────┤
│ - appointmentModel         │
│ - patientModel             │
│ - serviceModel             │
└────────────────────────────┘

┌────────────────────────────┐
│     AuthController         │
├────────────────────────────┤
│ - userModel: User          │
└────────────────────────────┘

┌────────────────────────────┐
│ Admin\DashboardController  │
├────────────────────────────┤
│ - appointmentModel         │
│ - patientModel             │
│ - serviceModel             │
│ - newsModel                │
└────────────────────────────┘

┌────────────────────────────┐
│         Router             │
├────────────────────────────┤
│ - routes: array            │
│ - basePath: string         │
└────────────────────────────┘

┌────────────────────────────┐
│          Auth              │
└────────────────────────────┘
         (static)
```
