FROM php:7.2.16-apache

RUN apt-get update  \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite

COPY apache2.conf /etc/apache2/sites-enabled/000-default.conf