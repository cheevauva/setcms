FROM php:8.1-cli

WORKDIR /setcms

RUN apt-get update
RUN apt-get install -y libxml2-dev
RUN apt-get install -y libzip-dev
RUN apt-get install -y zlib1g-dev
RUN apt-get install -y libpq-dev
RUN apt-get install -y nano

RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_pgsql pgsql
