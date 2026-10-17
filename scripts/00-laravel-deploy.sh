#!/usr/bin/env bash
echo "=== Kisii University Portal - Render Deployment Starting ==="

# Create and set permissions for SQLite database if used
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_CONNECTION" ]; then
    echo "Setting up SQLite database..."
    touch /var/www/html/database/database.sqlite
    chmod -R 777 /var/www/html/database
fi

# Set proper write permissions for storage and caches
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache

# Caching Laravel configurations
echo "Caching Laravel configuration, routes, and views..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Execute migrations and seeders
echo "Running database migrations..."
php artisan migrate --force --seed

echo "=== Deployment Completed Successfully ==="
