FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y libmemcached-dev libssl-dev zlib1g-dev bash \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug