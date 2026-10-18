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

# Ensure production-safe defaults for drivers that don't require database tables
# These can be overridden by Render environment variables
export SESSION_DRIVER="${SESSION_DRIVER:-cookie}"
export CACHE_STORE="${CACHE_STORE:-file}"
export QUEUE_CONNECTION="${QUEUE_CONNECTION:-sync}"

# Set up SQLite database
echo "Setting up SQLite database..."
touch database/database.sqlite
chown www-data:www-data database/database.sqlite
chmod 664 database/database.sqlite

# Clear config cache before caching (ensures fresh env vars are picked up)
php artisan config:clear

# Cache Laravel configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Run migrations (--force required in production)
# Show errors so deployment failures are visible in logs
echo "Running migrations..."
php artisan migrate --force 2>&1 || echo "WARNING: Migration failed — check logs above"

# Seed only if this is a fresh database (seeder should be idempotent)
php artisan db:seed --force 2>&1 || echo "WARNING: Seeding failed — check logs above"

echo "=== Ready — Launching Apache ==="

# Execute the CMD (apache2-foreground)
exec "$@"
