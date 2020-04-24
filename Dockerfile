FROM php:7.3-apache

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

COPY . /var/www/html
