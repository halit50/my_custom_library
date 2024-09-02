FROM php:8.1-apache

# 1. Ajouter "ServerName localhost" à la configuration d'Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 2. Mettre à jour les paquets et installer les dépendances nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends \
    locales apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev unzip

# 3. Configurer les locales
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

# 4. Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- && \
    mv composer.phar /usr/local/bin/composer

# 5. Installer Node.js
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash && \
    apt-get install -y nodejs

# 6. Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer -o /tmp/symfony_installer.sh

RUN bash /tmp/symfony_installer.sh

# 7. Configurer et installer les extensions PHP
RUN docker-php-ext-configure intl && \
    docker-php-ext-install pdo pdo_mysql opcache intl zip calendar dom mbstring gd xsl

# 8. Installer et activer le module APCu pour PHP
RUN pecl install apcu && docker-php-ext-enable apcu

WORKDIR /var/www/
