FROM composer:latest AS build
WORKDIR /www

COPY www/composer.json .
COPY www/composer.lock .
RUN composer install --no-dev --no-scripts --ignore-platform-reqs

COPY www .
RUN composer dumpautoload --optimize

FROM php:8-fpm
WORKDIR /www

RUN apt update && \
    apt install -y \
    libicu-dev=67.1-7 \
    libgd-dev=2.3.0-2 \
    libonig-dev=6.9.6-1.1 \
    unzip=6.0-26 && \
    apt purge -y --auto-remove

RUN docker-php-ext-install \
    exif \
    gd \
    intl \
    mbstring \
    mysqli \
    opcache \
    pdo_mysql \
    sockets

COPY --from=build /www /www