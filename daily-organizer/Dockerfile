# Dockerfile pour l'environnement de développement PHP

# Utiliser une image PHP-FPM basée sur Debian 12 (Bookworm)
FROM php:8.3-fpm-bookworm

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer les dépendances système requises pour les extensions PHP
# et les outils comme git et unzip
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install -j$(nproc) pdo_pgsql zip intl
RUN pecl install redis && docker-php-ext-enable redis

# Installer et activer Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Installer Composer (le gestionnaire de dépendances pour PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer un utilisateur non-root pour exécuter l'application
RUN groupadd -g 1000 app && \
    useradd -u 1000 -g app -m app

# Changer d'utilisateur
USER app

# Exposer le port pour PHP-FPM
EXPOSE 9000
