FROM php:8.1-apache


RUN apt-get update \
    && pecl install redis \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable redis \
    && a2enmod rewrite \
    && service apache2 restart

RUN rm -rf /var/lib/apt/lists/*
