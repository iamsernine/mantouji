# Dockerfile pour Mantouji Platform
FROM php:8.2-fpm

# Arguments
ARG user=mantouji
ARG uid=1000

# Installer les dépendances système et extensions PHP en une seule couche
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Node.js et npm (version LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer l'utilisateur système
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Définir le répertoire de travail
WORKDIR /var/www

# Copier uniquement les fichiers de dépendances d'abord (pour le cache)
COPY --chown=$user:$user composer.json composer.lock ./
COPY --chown=$user:$user package.json package-lock.json ./

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Installer les dépendances Node.js
RUN npm ci --only=production

# Copier le reste de l'application
COPY --chown=$user:$user . /var/www

# Compiler les assets
RUN npm run build

# Définir les permissions
RUN chown -R $user:$user /var/www && \
    chmod -R 755 /var/www/storage && \
    chmod -R 755 /var/www/bootstrap/cache

# Changer d'utilisateur
USER $user

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
