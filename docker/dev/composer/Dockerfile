FROM php:8.0-cli

WORKDIR /setcms

RUN apt-get update
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip
RUN php -r "copy('https://getcomposer.org/installer', '/composer-setup.php');" && \
    php /composer-setup.php  --version=2.3.5 --install-dir=/usr/local/bin && \
    php -r "unlink('/composer-setup.php');" 
