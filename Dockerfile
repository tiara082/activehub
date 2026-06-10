FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    npm

# PHP Extensions
RUN docker-php-ext-install \
    bcmath \
    intl \
    zip \
    pdo \
    pdo_pgsql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Install Node dependencies & build Vite assets
RUN npm install
RUN npm run build

# Laravel cache
RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

RUN mkdir -p storage/framework/{cache,sessions,views} \
    storage/logs bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

# Create storage symlink
RUN php artisan storage:link || true

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=$PORT