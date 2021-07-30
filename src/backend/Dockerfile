FROM php:7.4-fpm

RUN echo "Europe/Moscow" > /etc/timezone && ln -snf /usr/share/zoneinfo/Europe/Moscow /etc/localtime \
    && apt-get update -y \
    && apt-get install -y \
    libpng-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    zlib1g-dev \
    libzip-dev 

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY config/php.ini /usr/local/etc/php/php.ini
COPY config/zzz-phpSettings.conf /usr/local/etc/php-fpm.d/zzz-phpSettings.conf

RUN mkdir -p /var/log/php

RUN docker-php-ext-install mysqli gd zip pdo pdo_mysql

WORKDIR /var/www/backend

CMD ["php-fpm"]