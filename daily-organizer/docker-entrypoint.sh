#!/bin/sh
set -e

# Install PHP dependencies
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Install Node dependencies and build assets
if command -v npm >/dev/null 2>&1; then
  npm ci --omit=dev
  npm run build
fi

# Initialize database and run migrations
php bin/console doctrine:database:create --if-not-exists --no-interaction
php bin/console doctrine:migrations:migrate --no-interaction

exec php-fpm -F
