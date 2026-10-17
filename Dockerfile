FROM php:8.2-apache

# Install system dependencies and PHP extensions needed by Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl unzip libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev libpq-dev libonig-dev libicu-dev libsqlite3-dev nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo pdo_sqlite pdo_pgsql pdo_mysql mbstring gd zip bcmath intl pcntl exif \
    && a2enmod rewrite headers \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies (production only)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies and build Vite assets, then clean up
RUN npm ci --no-audit --no-fund && npm run build && rm -rf node_modules

# Remove dev-only hot file
RUN rm -f public/hot

# Set proper permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Point Apache to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable .htaccess overrides for Laravel routing
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy and enable startup script
COPY scripts/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
