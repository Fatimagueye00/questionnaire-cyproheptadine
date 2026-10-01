#!/bin/sh

# Préparer les dossiers Laravel
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# Supprimer l'ancien fichier de log et en recréer un avec les bonnes permissions
rm -f /var/www/html/storage/logs/laravel.log
touch /var/www/html/storage/logs/laravel.log

# Donner les bonnes permissions à Laravel
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Migrations
php artisan migrate --force

# Données de production
php artisan db:seed --class=ProductionDataSeeder --force

# Nettoyer les caches Laravel
php artisan config:clear
php artisan cache:clear

# Remettre les permissions après les commandes Laravel
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Démarrer Apache
exec apache2-foreground