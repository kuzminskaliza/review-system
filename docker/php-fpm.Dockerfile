FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

WORKDIR /var/www/review-system