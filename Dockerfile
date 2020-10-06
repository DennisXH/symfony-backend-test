FROM php:7.4-fpm-alpine as new-base
MAINTAINER Dennis Xie <dennisloveds@gmail.com>

RUN apk update && apk add --no-cache \
    bash \
    openssl \
    curl \
    nano \
    zlib-dev \
    libzip-dev \
    libxml2-dev
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    bcmath \
    calendar \
    exif \
    sockets \
    tokenizer \
    pcntl \
    xml \
    zip

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Change current user to www
USER www-data
COPY --chown=www-data:www-data ./ /var/www/app
# Setup working directory
WORKDIR /var/www/app