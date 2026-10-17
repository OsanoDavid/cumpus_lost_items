#!/bin/bash
set -e

echo "=== Kisii University Portal — Starting ==="

# Create storage directories if they don't exist
mkdir -p storage/framework/{sessions,views,cache/data}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chown -R www-data:www-data storage bootstrap/cache database
chmod -R 775 storage bootstrap/cache database

# Create .env from example if not present (Render env vars override values)
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate --force
fi

# Set up SQLite database
echo "Setting up SQLite database..."
touch database/database.sqlite
chown www-data:www-data database/database.sqlite
chmod 664 database/database.sqlite

# Cache Laravel configuration
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Run migrations (--force required in production, --seed for initial data)
echo "Running migrations..."
php artisan migrate --force --seed 2>/dev/null || php artisan migrate --force 2>/dev/null || true

echo "=== Ready — Launching Apache ==="

# Execute the CMD (apache2-foreground)
exec "$@"
