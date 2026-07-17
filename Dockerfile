FROM php:8.3-cli-bookworm AS base

WORKDIR /app

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libpq-dev \
        libzip-dev \
        libicu-dev \
        libxml2-dev \
        libcurl4-openssl-dev \
        libonig-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        mbstring \
        zip \
        intl \
        curl \
        dom \
        xml \
        xmlwriter \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

FROM base AS vendor

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

FROM node:20-bookworm AS assets

WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm ci
COPY resources ./resources
COPY public ./public
COPY . .
RUN npm run build

FROM base AS app

WORKDIR /app

COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build
COPY . .

EXPOSE 10000

CMD ["sh", "-c", "php artisan serve --host 0.0.0.0 --port ${PORT:-10000}"]
