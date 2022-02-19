FROM php:7.4-cli

WORKDIR /setcms

RUN apt-get update
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip
RUN php -r "copy('https://getcomposer.org/installer', '/composer-setup.php');" && \
    php /composer-setup.php  --version=1.10.22 --install-dir=/usr/local/bin && \
    php -r "unlink('/composer-setup.php');" 
