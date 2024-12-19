FROM php:8.3.8-apache

COPY .. /var/www
WORKDIR /var/www

RUN apt-get -y update

#add composer
RUN apt-get -y install git
COPY --from=composer /usr/bin/composer /usr/bin/composer

#configure apache
RUN a2enmod rewrite
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

#php-ext zip
RUN apt-get install -y \
        libzip-dev \
        zip \
        libicu-dev \
  && docker-php-ext-install zip

#php-ext mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql intl && docker-php-ext-enable mysqli