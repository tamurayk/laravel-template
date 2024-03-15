FROM php:8.2-fpm

COPY config/php.ini-development /usr/local/etc/php/php.ini

RUN set -eux \
    && apt-get update \
    && apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        p7zip-full \
        git \
    && docker-php-ext-install pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
