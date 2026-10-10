FROM php:8.3-apache

# Install system dependencies and required PHP extensions for Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . /var/www/html

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Point Apache DocumentRoot to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Default Production Environment Variables (TiDB Cloud & App Key)
ENV APP_NAME="ICS Merch Store" \
    APP_ENV=production \
    APP_KEY=base64:nA4qtVjXQldhv5uq2+GX0b8Mutklw5wP9woAQCjWotM= \
    APP_DEBUG=true \
    LOG_CHANNEL=stderr \
    DB_CONNECTION=mysql \
    DB_HOST=gateway01.ap-southeast-1.prod.aws.tidbcloud.com \
    DB_PORT=4000 \
    DB_DATABASE=my_laravel \
    DB_USERNAME=2Myo9Z5wk3AswFy.root \
    DB_PASSWORD=Jf5bnPqoLUSWfIap \
    MYSQL_ATTR_SSL_CA=true \
    MYSQL_ATTR_SSL_VERIFY_SERVER_CERT=false \
    SESSION_DRIVER=database \
    CACHE_STORE=array \
    ONEPASS_CLIENT_ID=cp3_client_ksPuSaN7bL7lAF9W8Enk \
    ONEPASS_CLIENT_SECRET=cp3_sec_nQxEeSfQXyRHdfecwA0yb6JPF5OZAOs5yXpl \
    ONEPASS_ISSUER_URL=https://onepass-gdbe.onrender.com

# Setup directory structure and permissions for storage, database, and bootstrap/cache
RUN mkdir -p /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache \
    && touch /var/www/html/database/database.sqlite \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Dynamic port binding for Render ($PORT or default 80)
EXPOSE 80 10000

CMD sh -c "touch /var/www/html/database/database.sqlite && sed -i \"s/80/\${PORT:-80}/g\" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && php artisan config:clear && php artisan view:clear && apache2-foreground"
