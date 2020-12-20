FROM php:7.4-fpm

ARG xdebug

## System Environment
ENV TZ UTC
ENV DEBIAN_FRONTEND noninteractive
ENV ENVIRONMENT dev

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        wget \
#        git \
        unzip \
        nano \
    && docker-php-ext-configure gd --with-freetype --with-jpeg

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

# Configure GIT
#RUN git config --global user.email "qurbonovshamil@gmail.com" && \
#    git config --global user.name "shamil8"

# Install PECL Dependencies
RUN docker-php-ext-install pdo pdo_mysql

#COPY docker/php/xdebug.sh /tmp/
#RUN chmod u+x /tmp/xdebug.sh && /tmp/xdebug.sh $xdebug

# Build Application
WORKDIR /var/www/adab-api
#RUN chown www-data:www-data /adab-api
COPY . .

RUN composer install
#USER www-data

RUN chmod -R 777 ./var

# copy something
# docker cp adab_api:var/www/adab-api/vendor/ ./vendor