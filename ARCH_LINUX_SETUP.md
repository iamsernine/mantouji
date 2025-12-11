# Guide d'Installation : Mantouji sur Arch Linux (Localhost)

Ce guide vous explique comment installer et exécuter le projet Mantouji directement sur votre système Arch Linux, sans utiliser Docker.

## Prérequis

- Un système Arch Linux à jour.
- `git` pour cloner le projet.
- `sudo` pour les droits d'administration.

## Étape 1 : Installer les Dépendances (PHP, MariaDB, Node.js)

Nous allons installer tous les paquets nécessaires en une seule commande.

```bash
sudo pacman -Syu --needed php php-gd php-intl mariadb composer nodejs npm
```

- **php** : L'interpréteur PHP.
- **php-gd, php-intl** : Extensions PHP requises par Laravel.
- **mariadb** : Le serveur de base de données.
- **composer** : Le gestionnaire de dépendances pour PHP.
- **nodejs, npm** : Pour compiler les assets JavaScript.

## Étape 2 : Configurer MariaDB (Base de Données)

### 1. Initialiser la base de données

```bash
sudo mariadb-install-db --user=mysql --basedir=/usr --datadir=/var/lib/mysql
```

### 2. Démarrer et activer le service MariaDB

```bash
sudo systemctl start mariadb.service
sudo systemctl enable mariadb.service
```

### 3. Sécuriser l'installation

```bash
sudo mariadb-secure-installation
```

Suivez les instructions. Il est crucial de **définir un mot de passe root** pour MariaDB.

### 4. Créer la base de données et l'utilisateur

Connectez-vous à MariaDB avec le mot de passe root que vous venez de créer :

```bash
sudo mariadb -u root -p
```

Ensuite, exécutez ces commandes SQL :

```sql
-- Créer la base de données
CREATE DATABASE mantouji CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Créer l'utilisateur 'mantouji_user' avec un mot de passe sécurisé
CREATE USER 'mantouji_user'@'localhost' IDENTIFIED BY 'mantouji_password';

-- Donner tous les privilèges à l'utilisateur sur la base de données
GRANT ALL PRIVILEGES ON mantouji.* TO 'mantouji_user'@'localhost';

-- Appliquer les changements
FLUSH PRIVILEGES;

-- Quitter
EXIT;
```

**Note** : Remplacez `mantouji_password` par un mot de passe de votre choix.

## Étape 3 : Configurer le Projet Mantouji

### 1. Cloner le projet (si ce n'est pas déjà fait)

```bash
cd ~/Desktop
git clone https://github.com/NEREUScode/mantouji.git
cd mantouji
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Configurer le fichier d'environnement (.env)

```bash
# Copier le fichier d'exemple
cp .env.example .env

# Ouvrir le fichier pour le modifier
nano .env
```

Modifiez les lignes suivantes avec les informations de votre base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mantouji
DB_USERNAME=mantouji_user
DB_PASSWORD=mantouji_password  # <-- Mettez le mot de passe que vous avez choisi
```

### 4. Générer la clé d'application

```bash
php artisan key:generate
```

### 5. Exécuter les migrations et les seeders

Cette commande va créer toutes les tables et insérer les données initiales (admin, filières).

```bash
php artisan migrate --seed
```

### 6. Installer les dépendances JavaScript et compiler les assets

```bash
npm install
npm run build
```

### 7. Créer le lien de stockage

Cela rendra les images et autres fichiers uploadés accessibles publiquement.

```bash
php artisan storage:link
```

## Étape 4 : Lancer le Serveur de Développement

Vous êtes prêt ! Lancez le serveur de développement de Laravel :

```bash
php artisan serve
```

Votre application est maintenant accessible à l'adresse suivante :

**http://127.0.0.1:8000**

## 🔐 Compte Admin par Défaut

- **Email** : `admin@mantouji.ma`
- **Mot de passe** : `admin123`

Vous pouvez maintenant vous connecter et gérer la plateforme.

## 🐛 En Cas de Problème

- **Erreur de base de données** : Vérifiez que le service MariaDB est bien en cours d'exécution (`sudo systemctl status mariadb.service`) et que vos identifiants dans le fichier `.env` sont corrects.
- **Erreur de permissions** : Assurez-vous que les répertoires `storage` et `bootstrap/cache` ont les bonnes permissions.
  ```bash
  sudo chmod -R 775 storage bootstrap/cache
  sudo chown -R $USER:www-data storage bootstrap/cache
  ```
- **Erreur `vite`** : Si vous avez une erreur liée à Vite, assurez-vous que `npm run build` s'est bien terminé sans erreur.

Ce guide devrait vous permettre de faire fonctionner le projet sans problème. N'hésitez pas si vous avez d'autres questions !
