# Stage 1: Build Frontend Assets
FROM node:20 AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP Application Setup
FROM php:8.3-cli
WORKDIR /app

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libpng-dev libzip-dev zip sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql pdo_pgsql zip bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .
COPY --from=frontend /app/public/build ./public/build

# Install production PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port
EXPOSE 8080

# Start command
CMD ["sh", "-c", "touch database/database.sqlite && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
