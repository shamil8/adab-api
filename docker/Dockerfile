FROM php:7.4-fpm

ARG xdebug

## System Environment
ENV TZ UTC
ENV DEBIAN_FRONTEND noninteractive
ENV ENVIRONMENT dev

# Application Environment
ENV DATABASE_HOST localhost
ENV DATABASE_PORT 3306
ENV DATABASE_NAME adab
ENV DATABASE_USER root
ENV DATABASE_PASS root
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

RUN apt-get update

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

# Configure GIT
#RUN git config --global user.email "you@example.com" && \
#    git config --global user.name "Your Name"

# Install PECL Dependencies
RUN docker-php-ext-install pdo pdo_mysql mysqli

#COPY docker/php/xdebug.sh /tmp/
#RUN chmod u+x /tmp/xdebug.sh && /tmp/xdebug.sh $xdebug

# Replace php.ini
#COPY ./php/php.ini "$PHP_INI_DIR/php.ini"
#ADD ./php/php.ini /etc/php/conf.d/
#ADD ./php/php.ini /etc/php/cli/conf.d/
#ADD ./php/php.ini /usr/local/etc/php

# Build Application
WORKDIR /var/www/
#RUN chown www-data:www-data /adab-api
#COPY . ./adab-api

#RUN mkdir /var/www/html/.composer && chown www-data:www-data /var/www/.composer

#USER www-data

#RUN composer install
