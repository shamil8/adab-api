FROM php:7.4-fpm

ARG xdebug

## System Environment
#ENV TZ UTC
#ENV DEBIAN_FRONTEND noninteractive
ENV ENVIRONMENT dev

# Application Environment
ENV DATABASE_URL=mysql://root:root@localhost:3306/adab
#ENV DATABASE_HOST localhost
#ENV DATABASE_PORT 5432
#ENV DATABASE_NAME adab
#ENV DATABASE_USER postgres
#ENV DATABASE_PASS root
#ENV MAILER_TRANSPORT smtp
#ENV MAILER_HOST ""
#ENV MAILER_PORT 25
#ENV MAILER_USER ""
#ENV MAILER_PASS ""
#ENV APP_SECRET ThisIsSuperSecretToken
#ENV ROOT_DOMAIN intr.dev
#ENV APP_DOMAIN app.intr.dev
#ENV STATIC_DOMAIN localhost
#ENV UPLOAD_DIR /uploads
#ENV MAIL_SYSTEM_HELP help@intr.dev
#ENV MAIL_SYSTEM_ADMIN admin@intr.dev
#ENV MAIL_NOREPLY_NAME noreply
#ENV MAIL_NOREPLY_ADDRESS noreply@intr.dev

#RUN apt-get update && apt-get install --no-install-recommends -y \
#    wget git unzip libonig-dev \
#    libxml2-dev libpng-dev \
#    libzip-dev libpq-dev

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN  apt-get install -y nano wget git
# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

# Configure GIT
RUN git config --global user.email "qurbonovshamil@gmail.com" && \
    git config --global user.name "shamil8"

# Install PECL Dependencies
RUN docker-php-ext-install pdo pdo_mysql
# pgsql

#COPY docker/php/xdebug.sh /tmp/
#RUN chmod u+x /tmp/xdebug.sh && /tmp/xdebug.sh $xdebug

# Replace php.ini
#COPY ./php/php.ini /usr/local/etc/php
#ADD ./php/php.ini /etc/php/pdo_mysql/
#ADD ./php/php.ini /etc/php/cli/conf.d/
#ADD ./php/php.ini /usr/local/etc/php

# Build Application
WORKDIR /var/www/adab-api
#RUN chown www-data:www-data /adab-api
#COPY . .

#RUN mkdir /var/www/html/.composer && chown www-data:www-data /var/www/.composer

#USER www-data

#RUN composer install
RUN apt-get install -y unzip libzip-dev