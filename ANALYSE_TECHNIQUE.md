# Analyse Technique - Plateforme Mantouji

## 📋 État Actuel du Projet

### Architecture Existante
- **Framework**: Laravel 12 avec PHP 8.2
- **Authentification**: Laravel Breeze
- **Frontend**: Blade templates + Vite + TailwindCSS
- **Base de données**: MySQL/MariaDB

### Modèles Existants

#### 1. User
- Champs: name, email, password, role, image
- Relations: hasOne(JamInfo), hasMany(Product)
- Rôles: 0 = Client, 1 = Coopérative (Jm3iya)

#### 2. Product
- Champs: name, image, reviews, reviews_number, user_id
- Relations: belongsTo(User), hasMany(Comment)
- Méthodes: averageRating(), reviewsCount()

#### 3. JamInfo
- Champs: description, contact, user_id
- Relations: belongsTo(User), hasMany(Product)
- Représente les informations de la coopérative

#### 4. Comment
- Champs: content, rating, product_id, user_id
- Relations: belongsTo(Product), belongsTo(User)

### Structure des Routes Actuelles

**Routes publiques:**
- `/` - Page d'accueil (actuellement vide)

**Routes authentifiées:**
- `/dashboard` - Redirection selon rôle
- `/jammiya` - Dashboard coopérative (role=1)
- `/coops` - Liste des coopératives (role=0)
- `/coops/{coop}` - Détails coopérative (role=0)

### Problèmes Identifiés

1. **Architecture incohérente**
   - Mélange de logique dans les routes
   - Nomenclature confuse (jammiya vs coop)
   - Pas de séparation claire admin/coop/client

2. **Modèles incomplets**
   - Pas de modèle Cooperative dédié
   - Pas de modèle Category/Filière
   - Product manque: description longue, prix, catégorie

3. **Sécurité et permissions**
   - Middleware "admin" pour role=1 (coopérative) - confusion
   - Pas de vrai rôle admin
   - Coopératives peuvent créer leurs comptes (problème)

4. **UI/UX**
   - Page d'accueil non fonctionnelle
   - Produits invisibles sans login
   - Design non professionnel

5. **Infrastructure**
   - Pas de Docker
   - Pas de documentation DB
   - Pas d'environnement de test stable

## 🎯 Plan de Refonte

### Phase 1: Restructuration de la Base de Données

#### Nouveaux Modèles à Créer

**1. Cooperative (Coopérative)**
```
- id
- name (nom de la coopérative)
- logo (upload)
- description
- email (optionnel)
- website (optionnel)
- whatsapp (obligatoire)
- sector_id (filière principale)
- is_active (actif/désactivé)
- created_by (admin_id)
- timestamps
```

**2. Sector (Filière)**
```
- id
- name (ex: Miel, Huile d'olive, Couscous)
- slug
- description
- icon (optionnel)
- timestamps
```

**3. Product (Refactorisé)**
```
- id
- name
- image
- short_description
- long_description
- price (optionnel)
- sector_id
- cooperative_id
- is_active
- timestamps
```

**4. User (Refactorisé)**
```
- id
- name
- email
- password
- role (0=client, 1=cooperative_user, 2=admin)
- cooperative_id (nullable, pour les users de coopératives)
- is_active
- timestamps
```

**5. Review (Avis/Notes)**
```
- id
- product_id
- user_id
- rating (1-5)
- comment
- is_approved
- timestamps
```

### Phase 2: Architecture du Code

#### Structure des Controllers

```
app/Http/Controllers/
├── Admin/
│   ├── DashboardController.php
│   ├── CooperativeController.php
│   ├── ProductController.php
│   ├── SectorController.php
│   ├── UserController.php
│   └── ReviewController.php
├── Public/
│   ├── HomeController.php
│   ├── ProductController.php
│   └── CooperativeController.php
└── Auth/
    └── (Breeze existant)
```

#### Middleware

```
- EnsureUserIsAdmin (role=2)
- EnsureUserIsCooperative (role=1)
- EnsureUserIsClient (role=0)
```

### Phase 3: Routes

```php
// Routes publiques (sans login)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/cooperatives', [CooperativeController::class, 'index'])->name('cooperatives.index');
Route::get('/cooperatives/{cooperative}', [CooperativeController::class, 'show'])->name('cooperatives.show');

// Routes clients authentifiés (pour avis/notes)
Route::middleware(['auth', 'client'])->group(function () {
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Routes admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('cooperatives', CooperativeController::class);
    Route::resource('products', ProductController::class);
    Route::resource('sectors', SectorController::class);
    Route::resource('users', UserController::class);
    Route::resource('reviews', ReviewController::class)->only(['index', 'update', 'destroy']);
});
```

### Phase 4: Design System

#### Palette de Couleurs Figuig

```css
/* Couleurs principales */
--oasis-green: #2D5016;      /* Vert oasis */
--palm-green: #4A7C2C;       /* Vert palmier */
--desert-sand: #D4A574;      /* Sable du désert */
--terracotta: #C65D3B;       /* Terracotta */
--sky-blue: #87CEEB;         /* Bleu ciel */
--earth-brown: #8B4513;      /* Brun terre */

/* Couleurs secondaires */
--light-sand: #F5E6D3;       /* Sable clair */
--dark-green: #1A3409;       /* Vert foncé */
--gold: #D4AF37;             /* Or (patrimoine) */
```

#### Composants UI

- Cards produits modernes avec hover effects
- Filtres élégants avec dropdowns
- Boutons WhatsApp avec icône
- Système de notation (étoiles)
- Modal pour avis/commentaires
- Dashboard admin avec statistiques visuelles

### Phase 5: Fonctionnalités Clés

#### 1. Page d'Accueil Publique
- Affichage de tous les produits (grid responsive)
- Filtres: par produit, coopérative, filière
- Barre de recherche
- Chaque carte produit:
  - Image
  - Nom
  - Nom de la coop
  - Filière
  - Note moyenne
  - Bouton "Message on WhatsApp"

#### 2. Page Produit
- Image grande taille
- Description complète
- Informations coopérative (logo, nom, contact)
- Bouton WhatsApp
- Section avis et notes (avec login pour poster)
- Autres produits de la coop

#### 3. Dashboard Admin
- Vue statistiques:
  - Nombre de coopératives
  - Nombre de produits
  - Nombre d'utilisateurs
  - Avis récents
- CRUD complet:
  - Gestion coopératives (créer, modifier, activer/désactiver)
  - Gestion produits
  - Gestion filières
  - Gestion utilisateurs (créer comptes coopératives)
- Tableau des avis/notes avec modération

### Phase 6: Conteneurisation

#### Dockerfile
```dockerfile
FROM php:8.2-fpm
# Installation des dépendances
# Configuration PHP
# Composer install
# NPM build
```

#### docker-compose.yml
```yaml
services:
  app:
    build: .
    volumes:
      - ./:/var/www/html
  
  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
  
  mysql:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: mantouji
      MYSQL_ROOT_PASSWORD: secret
    volumes:
      - mysql_data:/var/lib/mysql
  
volumes:
  mysql_data:
```

### Phase 7: Documentation

#### 1. Schéma Base de Données
- Diagramme ERD complet
- Description de chaque table
- Relations et contraintes
- Index et optimisations

#### 2. Tutoriel Installation Arch Linux
- Installation MySQL/MariaDB
- Création utilisateur et base
- Import du schéma
- Configuration systemd
- Configuration Laravel (.env)

## 📊 Métriques de Qualité

- Code coverage > 80%
- PSR-12 compliance
- Pas de code dupliqué
- Documentation inline
- Commits atomiques et descriptifs

## 🚀 Ordre d'Implémentation

1. ✅ Analyse technique (actuel)
2. Migrations et modèles
3. Seeders pour données de test
4. Controllers et routes
5. Views et composants UI
6. Design et CSS
7. Tests unitaires et fonctionnels
8. Docker et conteneurisation
9. Documentation
10. Déploiement et tests finaux
