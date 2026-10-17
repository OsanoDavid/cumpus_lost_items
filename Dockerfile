FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html

# Install Node.js for building Vite assets
RUN apk add --no-cache nodejs npm

# Copy all project files
COPY . .

# Install Node dependencies and build frontend assets
RUN npm ci --no-audit --no-fund && npm run build && rm -rf node_modules

# Nginx & PHP-FPM Configuration
ENV SKIP_COMPOSER 0
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel environment defaults
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# Remove dev hot file if present (breaks production asset loading)
RUN rm -f /var/www/html/public/hot

EXPOSE 80

CMD ["/start.sh"]
