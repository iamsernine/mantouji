# Guide de Déploiement Docker - Mantouji Platform

## 📦 Prérequis

- Docker Engine 20.10+
- Docker Compose 2.0+
- Git

## 🚀 Installation et Démarrage

### 1. Cloner le projet

```bash
git clone https://github.com/NEREUScode/mantouji.git
cd mantouji
```

### 2. Configuration de l'environnement

Copier le fichier `.env.example` et configurer les variables :

```bash
cp .env.example .env
```

Modifier les variables suivantes dans `.env` :

```env
APP_NAME=Mantouji
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=mantouji
DB_USERNAME=mantouji_user
DB_PASSWORD=mantouji_password
```

### 3. Construire et démarrer les containers

```bash
# Construire les images
docker-compose build

# Démarrer les services
docker-compose up -d
```

### 4. Initialisation de l'application

```bash
# Générer la clé d'application
docker-compose exec app php artisan key:generate

# Exécuter les migrations
docker-compose exec app php artisan migrate --seed

# Créer le lien symbolique pour le storage
docker-compose exec app php artisan storage:link

# Optimiser l'application
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

### 5. Accéder à l'application

- **Application principale** : http://localhost
- **phpMyAdmin** : http://localhost:8080
  - Serveur : `mysql`
  - Utilisateur : `mantouji_user`
  - Mot de passe : `mantouji_password`

## 🔐 Compte Admin par Défaut

Après l'exécution des seeders, vous pouvez vous connecter avec :

- **Email** : admin@mantouji.ma
- **Mot de passe** : admin123

⚠️ **Important** : Changez immédiatement ce mot de passe en production !

## 📊 Services Docker

Le stack Docker comprend :

| Service | Container | Port | Description |
|---------|-----------|------|-------------|
| app | mantouji-app | 9000 | Application Laravel (PHP-FPM) |
| nginx | mantouji-nginx | 80, 443 | Serveur web Nginx |
| mysql | mantouji-mysql | 3306 | Base de données MySQL 8.0 |
| phpmyadmin | mantouji-phpmyadmin | 8080 | Interface de gestion MySQL |

## 🛠️ Commandes Utiles

### Gestion des containers

```bash
# Démarrer les services
docker-compose up -d

# Arrêter les services
docker-compose down

# Voir les logs
docker-compose logs -f

# Voir les logs d'un service spécifique
docker-compose logs -f app

# Redémarrer un service
docker-compose restart app
```

### Commandes Laravel

```bash
# Accéder au shell du container
docker-compose exec app bash

# Exécuter Artisan
docker-compose exec app php artisan <commande>

# Exécuter les migrations
docker-compose exec app php artisan migrate

# Créer un utilisateur admin
docker-compose exec app php artisan tinker
>>> User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role' => 2, 'is_active' => true]);

# Nettoyer le cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Base de données

```bash
# Backup de la base de données
docker-compose exec mysql mysqldump -u mantouji_user -pmantouji_password mantouji > backup.sql

# Restaurer la base de données
docker-compose exec -T mysql mysql -u mantouji_user -pmantouji_password mantouji < backup.sql

# Accéder à MySQL CLI
docker-compose exec mysql mysql -u mantouji_user -pmantouji_password mantouji
```

## 🔧 Configuration Avancée

### Volumes Persistants

Les données suivantes sont persistées :

- **mysql_data** : Données de la base de données
- **./storage** : Fichiers uploadés et logs
- **./bootstrap/cache** : Cache de l'application

### Variables d'Environnement

Vous pouvez personnaliser les variables suivantes dans `docker-compose.yml` :

```yaml
environment:
  MYSQL_DATABASE: mantouji
  MYSQL_USER: mantouji_user
  MYSQL_PASSWORD: mantouji_password
  MYSQL_ROOT_PASSWORD: root_password
```

### SSL/HTTPS

Pour activer HTTPS, ajoutez vos certificats SSL dans `docker/nginx/ssl/` et modifiez la configuration nginx.

## 🐛 Dépannage

### Problème de permissions

```bash
# Corriger les permissions
docker-compose exec app chown -R www-data:www-data /var/www/storage
docker-compose exec app chmod -R 775 /var/www/storage
```

### Erreur de connexion à la base de données

Vérifiez que le service MySQL est démarré :

```bash
docker-compose ps
docker-compose logs mysql
```

### Réinitialiser complètement

```bash
# Arrêter et supprimer tous les containers et volumes
docker-compose down -v

# Reconstruire et redémarrer
docker-compose build --no-cache
docker-compose up -d
```

## 📝 Notes de Production

### Sécurité

1. Changez tous les mots de passe par défaut
2. Désactivez phpMyAdmin en production
3. Configurez un pare-feu (UFW, iptables)
4. Utilisez HTTPS avec des certificats valides
5. Limitez l'accès SSH

### Performance

1. Activez le cache Laravel :
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. Configurez Redis pour les sessions et le cache (optionnel)

3. Optimisez la configuration MySQL dans `docker-compose.yml`

### Monitoring

Ajoutez des outils de monitoring :
- Prometheus + Grafana
- ELK Stack pour les logs
- Uptime monitoring

## 📚 Ressources

- [Documentation Laravel](https://laravel.com/docs)
- [Documentation Docker](https://docs.docker.com)
- [Documentation Nginx](https://nginx.org/en/docs)
- [Documentation MySQL](https://dev.mysql.com/doc)

## 🆘 Support

Pour toute question ou problème :
- Ouvrir une issue sur GitHub
- Contacter : contact@mantouji.ma
