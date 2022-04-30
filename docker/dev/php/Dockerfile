FROM php:8.0-fpm

WORKDIR /setcms/backend

RUN apt-get update

RUN apt-get install -y zlib1g-dev
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql pgsql

CMD ["php-fpm"]