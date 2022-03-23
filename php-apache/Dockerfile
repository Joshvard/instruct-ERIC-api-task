FROM php:8.0-apache

RUN apt update \
        && apt install npm -y \
        && apt install -y \
            g++ \
            libicu-dev \
            libpq-dev \
            libzip-dev \
            zip \
            zlib1g-dev \
        && docker-php-ext-install \
            intl \
            opcache \
            pdo \
            pdo_pgsql \
            pgsql 

# Install composer and mysqli library
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

# Create custom cli command
RUN echo 'alias serviceCli="php /var/www/html/cli/serviceCli.php"' >> ~/.bashrc