FROM php:8.3-fpm

WORKDIR /app

USER root

COPY --chown=www:www ./ /app
COPY --chown=www:www composer.json /app/composer.json

RUN apt-get -y update &&\
    apt-get install -y --no-install-recommends unzip \
    git \
    curl \
    vim \
    libpng-dev libjpeg-dev libpq-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
## Installing the NodeSource Node.js 18.x repo...
## Populating apt-get cache...
## Creating apt sources list file for the NodeSource Node.js 18.x repo...
#RUN apt-get update -y && apt-get install nodejs -y

# Instalar dependências do libzip
RUN apt-get install -y libzip-dev && \
    docker-php-ext-configure zip && \
    docker-php-ext-install zip \
    && apt-get clean

RUN docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install gd pdo pdo_pgsql

# Install Composer in a writable directory
RUN mkdir -p /tmp/composer && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/tmp/composer --filename=composer

# Move Composer to a directory in the PATH
RUN mv /tmp/composer/composer /usr/local/bin/composer && \
    rm -rf /tmp/composer

# Add user for laravel application
#RUN groupadd -g 1000 www-data
#RUN useradd -u 1000 -ms /bin/bash -g www-data www-data

# Ignore ssl verify
RUN git config --global http.sslVerify false

RUN composer config --no-plugins allow-plugins.kylekatarnls/update-helper true && \
    composer install

EXPOSE 8000

RUN chown -R www-data /app
RUN chmod -R 777 /app/storage