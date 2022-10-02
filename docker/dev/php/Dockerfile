FROM php:8.1-fpm

WORKDIR /setcms/backend

RUN apt-get update

RUN apt-get install -y zlib1g-dev
RUN apt-get install -y libpq-dev
RUN apt-get install -y libpng-dev
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install pdo pdo_pgsql pgsql gd zip

CMD ["php-fpm"]