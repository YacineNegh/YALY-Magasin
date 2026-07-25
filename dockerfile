# ---- Stage 1: build the Vite/React/Tailwind frontend ----
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---- Stage 2: PHP app + nginx ----
# Pinned to 8.4: your composer.lock (symfony/error-handler v8.1.0) requires PHP >=8.4.1,
# and the 8.5-fpm-alpine tag wasn't resolving correctly during the build.
FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    nginx supervisor bash curl git unzip sqlite sqlite-dev \
    libpng-dev libzip-dev oniguruma-dev icu-dev gettext \
    curl-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_sqlite mbstring bcmath gd zip pcntl exif intl curl xml dom simplexml xmlwriter soap

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN composer dump-autoload --optimize \
    && mkdir -p database storage/framework/{cache,sessions,views} bootstrap/cache \
    && touch database/database.sqlite \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache

COPY docker/nginx.conf.template /etc/nginx/http.d/default.conf.template
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 10000
CMD ["/start.sh"]