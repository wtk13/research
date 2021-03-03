FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip \
    libpng-dev \
    libzip-dev \
    librabbitmq-dev \
    libssh-dev postgresql postgresql-client postgresql-contrib libpq-dev imagemagick \
    libjpeg-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_pgsql

RUN echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;
