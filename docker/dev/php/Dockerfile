FROM dunglas/frankenphp:1-php8.4-bookworm

RUN install-php-extensions pdo pdo_sqlite gd zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

WORKDIR /var/www/html

EXPOSE 80

CMD ["frankenphp", "php-server"]