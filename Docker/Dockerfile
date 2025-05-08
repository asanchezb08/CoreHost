FROM php:8.2-apache

# Instal·lar eines i extensions necessàries
RUN apt-get update && apt-get install -y \
    nano \
    wget \
    mariadb-client \
    && docker-php-ext-install mysqli pdo_mysql

# Desactivar warnings, notices i deprecated
RUN echo "display_errors = Off" > /usr/local/etc/php/conf.d/00-errors.ini && \
    echo "error_reporting = E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING" >> /usr/local/etc/php/conf.d/00-errors.ini

# Copiar el contingut de l'aplicació
COPY . /var/www/html/

# Assignar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
